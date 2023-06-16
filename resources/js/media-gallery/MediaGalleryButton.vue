<template>
  <div>
    <button type="button" class="btn btn-primary" @click="openGallery">
      Open Gallery
    </button>
  </div>
</template>
<script>
export default {
  inject: ["bus"],
  methods: {
    openGallery() {
      this.bus.$emit('open-gallery', {
        callback: this.callback
      });
    },
    callback(event) {
      this.$emit('input', event);
    }
  }
}
</script>