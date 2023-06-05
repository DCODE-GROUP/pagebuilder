<template>
  <div>
    <tinymce-editor v-model="content" :init="config" @change="handleChange"></tinymce-editor>
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
  components: {
    "tinymce-editor": Editor,
  },
  data() {
    return {
      content: this.modelValue,
      config: this.init ?? tinymceConfig.config,
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