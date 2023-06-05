<template>
  <div>
    <div class="flex mb-4 space-x-4">
      <div class="w-1/2">
        <label class="form-label">Heading</label>
        <input
            type="text"
            class="form-input"
            v-model="heading"
            @keyup="update('heading')"
        />
      </div>
      <div class="w-1/2">
        <label class="form-label">Sub heading</label>
        <input
            type="text"
            class="form-input"
            v-model="sub_heading"
            @keyup="update('sub_heading')"
        />
      </div>
    </div>

    <div class="mb-4">
      <label class="form-label">Body</label>
      <editor v-model="body" @change="update('body')"></editor>
    </div>

    <label class="sm-toggleable sm-switch" for="singleColumnPadding">
      <input type="checkbox" id="singleColumnPadding" v-model="padding" @change="update('padding')"/>
      <span class="form-label">Padding</span>
    </label>
  </div>
</template>

<script>
import Module from "../Module.vue";
import Editor from "../Editor.vue"


export default {
  extends: Module,
  components: {
    Editor
  },
  data() {
    return {
      sub_heading: null,
      heading: null,
      body: null,
      padding: false,
    }
  },
  mounted() {
    this.sub_heading = this.fields.sub_heading.value;
    this.heading = this.fields.heading.value;
    this.body = this.fields.body.value;
    this.padding = this.fields.padding.value;
  },
}
</script>
