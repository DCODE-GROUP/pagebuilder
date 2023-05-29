<template>
  <div>
    <div class="mb-2">
      <button class="btn btn-primary" @click="showCreate = !showCreate">Create Folder</button>
    </div>
    <div v-if="showCreate" class="my-2">
      <div class="my-2">
        <input type="text" v-model="newFolder.name">
      </div>
      <button class="btn btn-primary" @click="saveFolder">Save</button>
    </div>
    <div v-for="folder in folders">
      <span class="cursor-pointer hover:underline hover:text-teal-500 transition-colors" @click="setCurrentFolder(folder)">
        {{ folder.name }}
      </span>
    </div>
  </div>
</template>
<script>
import axios from "axios"

export default {
  inject: ["bus"],
  props: {
    getFoldersEndpoint: String,
    saveFolderEndpoint: String,
  },
  created() {
    this.getFolders();
  },
  data() {
    return {
      currentFolder: null,
      folders: [],
      showCreate: false,
      newFolder: {},
    }
  },
  methods: {
    async getFolders() {
      const response = await axios.get(this.getFoldersEndpoint);

      if (response.data.folders) {
        this.folders = response.data.folders;
      }
    },
    async saveFolder() {
      const response = await axios.post(this.saveFolderEndpoint, this.newFolder);

      if (response.data.folder) {
        await this.getFolders();
        this.showCreate = false;
        this.newFolder = {};
      }
    },
    setCurrentFolder(folder) {
      this.currentFolder = folder;
      this.$emit('setCurrentFolder', {
        folder: this.currentFolder,
      });
    },
  },
}
</script>