<template>
  <div>
    <form :action="action" :method="method">
      <input type="hidden" name="_method" :value="method">
      <slot name="fields" />
    </form>
  </div>
</template>
<script>
import axios from "axios";

export default {
  inject: ["bus"],
  props: {
    storeAction: {
      type: String,
      required: true,
    },
    updateAction: {
      type: String,
      required: true,
    },
    defaultPage: {
      type: Object,
      required: true,
    },
    defaultMethod: {
      type: String,
      required: false,
    },
  },
  created() {
    this.bus.$on('title-filled', (data) => {
      this.handleCreate(data);
    });
    this.replaceActionParam();
  },
  data() {
    return {
      action: this.defaultPage.id ? this.updateAction : this.storeAction,
      method: this.defaultPage.id ? 'put' : 'post',
      page: this.defaultPage,
    }
  },
  methods: {
    async handleCreate(data) {
      if (this.page.id) {
        return;
      }

      const response = await axios.post(this.action, data);

      if (response.data) {
        this.page = response.data.page;
        this.action = this.updateAction;

        this.bus.$emit('set-page', this.page);

        this.replaceActionParam();
      }
    },
    replaceActionParam() {
      if (this.action.includes(':page')) {
        this.action = this.action.replace(':page', this.page.id);
        this.method = "put";
      }
    }
  }
}
</script>