<script>
export default {
  props: {
    id: String,
    fields: Object,
    pageModel: Object,
    pageModelClass: String,
    mediaUploadEndpoint: String,
    getFoldersEndpoint: String,
    saveFolderEndpoint: String,
    galleryMediaUploadEndpoint: String,
    getFolderEndpoint: String,
    mediaIndexEndpoint: String,
  },
  methods: {
    update(name, value) {
      if (typeof value !== 'undefined') {
        this[name] = value;
      }

      this.$emit('update-content', [this.id, name, this[name]]);
    },

    updateObject(name, index, key) {
      const i = _.findIndex(this[name], (o) => {
        return o.id === id;
      });

      this.$emit('update-content', [this.id, name, this[name][i][key]]);
    }
  }
}
</script>
