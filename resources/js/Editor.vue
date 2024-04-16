<template>
  <div>
    <tinymce-editor v-model="content" :api-key="tinyMceLicenseKey" :init="config" @change="handleChange"></tinymce-editor>
  </div>
</template>
<script>
import tinymceConfig from "./config/tinymce";
import Editor from "@tinymce/tinymce-vue"

export default {
  props: {
    init: Object,
    modelValue: '',
  },
  inject: ["tinyMceLicenseKey"],
  components: {
    "tinymce-editor": Editor,
  },
  data() {
    return {
      content: this.modelValue,
      config: this.init ?? tinymceConfig.config,
      tinyMceLicenseKey: this.tinyMceLicenseKey,
    }
  },
  methods: {
    handleChange(event) {
      this.$emit('update:modelValue', this.content);
      this.$emit('change', this.content);
    },
  },
  watch: {
    modelValue: function (newValue, oldValue) {
      this.content = newValue;
    }
  }
}
</script>