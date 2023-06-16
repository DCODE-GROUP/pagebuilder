<template>
  <div>
    <ul>
      <li v-for="child in children">
        <folder @setCurrentFolder="(event) => setCurrentFolder(event.folder)" v-if="child.children" :folder="child"></folder>
        <span v-else class="cursor-pointer hover:underline hover:text-teal-500 transition-colors" @click="setCurrentFolder(child)">
          {{ child.name }}
        </span>
      </li>
    </ul>
  </div>
</template>
<script>
// import Folder from "./Folder.vue"

export default {
  props: {
    children: Array,
  },
  components: {
    // Folder
  },
  methods: {
    setCurrentFolder(folder) {
      this.$emit('setCurrentFolder', {
        folder: folder,
      });
    }
  }
}
</script>
<style>
ul {
  padding-left: 15px
}
</style>