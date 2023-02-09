<template>
  <div class="flex">
    <div>
      <label :for="field">Desktop:</label>
      <div v-if="desktop?.url" class="w-1/2 h-32" :style="{ backgroundImage: desktop?.url }">

      </div>
      <input type="file" :name="field" :id="field" @change="handleDesktopUpload">
    </div>
    <div>
      <label :for="'mobile_'+field">Mobile:</label>
      <div v-if="mobile?.url" class="w-1/2 h-32" :style="{ backgroundImage: mobile?.url }">

      </div>
      <input type="file" :name="'mobile_'+field" :id="'mobile_'+field" @change="handleMobileUpload">
    </div>
  </div>
</template>
<script>
import axios from "axios"

export default {
  inject: ["bus"],
  props: {
    defaultModel: {
      type: Object,
      required: true,
    },
    modelClass: {
      type: String,
      required: true,
    },
    field: {
      type: String,
      required: true,
    },
    uploadEndpoint: {
      type: String,
      required: true,
    },
    desktopImage: {
      type: Object,
      required: false,
    },
    mobileImage: {
      type: Object,
      required: false,
    },
  },
  created() {
    this.bus.$on('set-page', (page) => {
      this.model = page;
    })
  },
  data() {
    return {
      desktop: this.desktopImage ?? null,
      mobile: this.mobileImage ?? null,
      model: this.defaultModel ?? null,
    }
  },
  methods: {
    async handleDesktopUpload(event) {
      this.desktop = await this.handleUpload(event);
    },
    async handleMobileUpload(event) {
      this.mobile = await this.handleUpload(event);
    },
    async handleUpload(event) {
      const formData = new FormData();

      formData.append("file", event.target.files[0]);
      formData.append("modelId", this.model.id);
      formData.append("modelClass", this.modelClass);
      formData.append("field", this.field);
      const response = await axios.post(this.uploadEndpoint, formData, {
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'multipart/form-data',
        }
      })

      if (response.data.media) {
        this.$emit('input', response.data.media);
        return response.data.media;
      }

      return false;
    },
  },
}
</script>
<style>

</style>