<template>
  <div>
    <button type="submit" class="btn btn-primary" :disabled="disabled">
      <i class="mr-2 fa-regular fa-floppy-disk"></i>
      Update page
    </button>
  </div>
</template>
<script>
export default {
  inject: ["bus"],
  props: {
    defaultValue: {
      type: Boolean,
      required: true,
    }
  },
  created() {
    this.bus.$on('title-filled', () => {
      this.disabled = false;
    });
  },
  data() {
    return {
      disabled: this.defaultValue,
    }
  }
}
</script>