<template>
  <div>
    <gallery-modal custom-class="w-1/2">
      <div class="flex">
        <div class="w-1/3">
          <folders
              :get-folders-endpoint="getFoldersEndpoint"
              :save-folder-endpoint="saveFolderEndpoint"
              @setCurrentFolder="setCurrentFolder"
          ></folders>
        </div>
        <div class="w-2/3">
          <div v-if="currentFolder">
            <div>
              <div class="mb-2">
                Selected folder: {{ currentFolder.name }}
              </div>
              <image-upload
                  :current-folder="currentFolder"
                  :upload-endpoint="galleryMediaUploadEndpoint"
                  @input="handleImageInput"
              ></image-upload>
            </div>
            <div>
              <search @search="handleSearch"></search>
              <hr class="my-4">
              <div class="flex flex-wrap max-h-96 overflow-y-scroll items-start">
                <div class="w-1/3 p-2 cursor-pointer" v-for="image in images" @click="handleClick(image)">
                  <img class="object-cover w-full" :src="image.url">
                  <div class="text-center text-xs">
                    {{ image.custom_properties.original_filename }}
                  </div>
                </div>
                <div v-if="images.length < 1">
                  No files uploaded yet!
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            Select a folder to proceed
          </div>
        </div>
      </div>
    </gallery-modal>
  </div>
</template>
<script>
import Folders from "./Folders.vue";
import GalleryModal from "./GalleryModal.vue";
import ImageUpload from "./ImageUpload.vue";
import Search from "./Search.vue";

export default {
  inject: ["bus"],
  props: {
    getFoldersEndpoint: String,
    saveFolderEndpoint: String,
    galleryMediaUploadEndpoint: String,
    getFolderEndpoint: String,
    mediaIndexEndpoint: String,
  },
  components: {
    Folders, GalleryModal, ImageUpload,
    Search,
  },
  created() {
    window.addEventListener('open-gallery', (payload) => {
      this.callback = payload.callback;
    })

    this.bus.$on('open-gallery', (payload) => {
      this.callback = payload.callback;
    });
  },
  data() {
    return {
      currentFolder: null,
      isVisible: false,
      getFolderUrl: this.getFolderEndpoint,
      images: [],
      searchString: '',
      searchType: '',
      searchSize: 0,
      callback: null,
    }
  },
  methods: {
    setCurrentFolder(event) {
      this.currentFolder = event.folder;

      this.getAllMedia();
    },
    handleImageInput(event) {
      this.getAllMedia();
    },
    async refreshCurrentFolder() {
      const response = await axios.get(this.getFolderUrl)

      this.currentFolder = response.data.folder;
    },
    handleClick(media) {
      const data = {
        media: media
      };
      this.$emit('input', data);

      this.bus.$emit('close-gallery');

      if (this.callback) {
        this.callback(data);
      }
    },
    handleSearch(event) {
      this.searchString = event.search;
      this.searchType = event.type;
      this.searchSize = event.size;

      this.getAllMedia();
    },
    async getAllMedia() {
      let url = new URL(this.mediaIndexEndpoint);

      url.searchParams.set('folder_id', this.currentFolder.id);
      url.searchParams.set('search', this.searchString);
      url.searchParams.set('type', this.searchType);
      url.searchParams.set('size', this.searchSize);

      const response = await axios.get(url);

      this.images = response.data.media;
    }
  }
}
</script>
<style>

</style>