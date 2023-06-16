<template>
  <div>
    <div class="flex justify-between">
      <div class="w-1/3">
        Name:
        <input class="w-full" name="search" id="search" type="text" v-model="search">
      </div>
      <div class="w-1/4">
        Max. Size:
        <input class="w-full" name="size" id="size" type="number" v-model="size">
      </div>
      <div class="w-1/3">
        Type:
        <select class="w-full" name="type" id="type" v-model="type">
          <option value="">-</option>
          <option value="image/jpeg">JPEG</option>
          <option value="image/png">PNG</option>
          <option value="application/pdf">PDF</option>
        </select>
      </div>
    </div>
  </div>
</template>
<script>
import _ from "lodash";

export default {
  data() {
    return {
      search: '',
      size: 0,
      type: '',
    }
  },
  methods: {
    handleInput() {
      this.$emit('search', {
        search: this.search,
        size: this.size,
        type: this.type
      });
    }
  },
  watch: {
    search: _.debounce(function() {
      this.handleInput();
    }, 300),
    size: _.debounce(function() {
      this.handleInput();
    }, 300),
    type: _.debounce(function() {
      this.handleInput();
    }, 300),
  }
}
</script>