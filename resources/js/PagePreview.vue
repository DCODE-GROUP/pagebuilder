<template>
  <div>
    <shadow-root>
      <div v-html="html"></div>
    </shadow-root>
  </div>
</template>
<script>
export default {
  inject: ["bus"],
  props: {
    pageId: String
  },
  data() {
    return {
      isLoading: false,
      url: `/admin/pages/preview`,
      html: null,
    }
  },
  created() {
    this.bus.$on('refresh-preview', () => {
      this.preview();
    });
  },
  mounted() {
    this.preview();
  },
  methods: {
    preview() {
      this.isLoading = true;

      axios.post(this.url, {
        title: document.querySelector('#title').value,
        abstract: document.querySelector('#abstract').value,
        content: document.querySelector('[name="content"').value
      })
          .then((response) => {
            this.html = response.data.page;
          })
          .catch(error => {
            alert('An error occurred while fetching your preview, please try again')
          })
          .then(() => {
            this.isLoading = false;
          });
    }
  },
}
</script>