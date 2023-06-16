<template>
  <div>
    <span class="cursor-pointer hover:underline hover:text-teal-500 transition-colors" @click="setCurrentFolder(folder)">
        {{ folder.name }}
    </span>
    <folder-content @setCurrentFolder="(event) => setCurrentFolder(event.folder)" :children="folder.children"></folder-content>
  </div>
</template>
<script>
import FolderContent from "./FolderContent.vue"

export default {
  props: {
    folder: Object
  },
  components: {
    FolderContent
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