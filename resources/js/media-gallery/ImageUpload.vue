<template>
  <div>
    <div class="flex justify-between my-2">
      <div class="w-1/2">
        <input type="file" @change="handleChange">
      </div>
      <div>
        <button class="btn btn-primary" @click="handleUpload">Upload</button>
      </div>
    </div>
    <hr />
  </div>
</template>
<script>
import axios from "axios"
import Toastify from 'toastify-js';

export default {
  props: {
    currentFolder: Object,
    uploadEndpoint: String,
  },
  data() {
    return {
      file: null,
    }
  },
  methods: {
    handleChange() {
      this.file = event.target.files[0];
    },
    async handleUpload() {
      const formData = new FormData();

      formData.append("file", this.file);
      formData.append("folder_id", this.currentFolder?.id);
      try {
        const response = await axios.post(this.uploadEndpoint, formData, {
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'multipart/form-data',
          }
        });

        this.$emit('input', {
          media: response.data.media,
        });



        Toastify({
          text: response.data.message,
          duration: 3000,
          close: true,
          gravity: "top", // `top` or `bottom`
          position: "left", // `left`, `center` or `right`
          stopOnFocus: true, // Prevents dismissing of toast on hover
        }).showToast();
      } catch(e) {
        Toastify({
          text: e.response.data.message,
          duration: 3000,
          close: true,
          gravity: "top", // `top` or `bottom`
          position: "left", // `left`, `center` or `right`
          stopOnFocus: true, // Prevents dismissing of toast on hover
          style: {
            background: "#FF0000",
          },
        }).showToast();
      }
    },
  }
}
</script>