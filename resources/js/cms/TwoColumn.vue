<template>
  <div>
    <div class="mb-4">
      <label class="form-label">Heading</label>
      <input type="text" class="form-input" v-model="heading" @keyup="update('heading')"/>
    </div>

    <div class="mb-4">
      <label class="form-label">First column content</label>
      <tinymce-editor v-model="body_one" :init="tinyMCEConfig" @change="update('body_one')"></tinymce-editor>
    </div>

    <div class="mb-4">
      <label class="form-label">Second column content</label>
      <tinymce-editor v-model="body_two" :init="tinyMCEConfig" @change="update('body_two')"></tinymce-editor>
    </div>

    <label class="sm-toggleable sm-switch" for="twoColumnPadding">
      <input type="checkbox" id="twoColumnPadding" v-model="padding" @change="update('padding')"/>
      <span class="form-label">Padding</span>
    </label>

  </div>
</template>

<script>
import Module from "../Module.vue"
import Editor from "@tinymce/tinymce-vue"

export default {
  extends: Module,
  components: {
    "tinymce-editor": Editor
  },
  data() {
    return {
      heading: null,
      body_one: null,
      body_two: null,
      padding: false,
      tinyMCEConfig: {},
    }
  },
  mounted() {
    this.heading = this.fields.heading.value;
    this.body_one = this.fields.body_one.value;
    this.body_two = this.fields.body_two.value;
    this.padding = this.fields.padding.value;
  }
}
</script>
