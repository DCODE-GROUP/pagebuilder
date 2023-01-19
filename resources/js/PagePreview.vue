<template>
  <div class="flex flex-col flex-1 items-center bg-primary-400">
    <div class="w-full flex py-2 justify-center">
      <div class="btn-group space-x-4">
        <button type="button" class="btn btn-primary-outlined" @click="setWidth('1920')">1920px</button>
        <button type="button" class="btn btn-primary-outlined" @click="setWidth('1440')">1440px</button>
        <button type="button" class="btn btn-primary-outlined" @click="setWidth('768')">768px</button>
      </div>
    </div>
    <div class="overflow-hidden" style="height: 720px;" :style="wrapperStyle">
      <iframe :srcdoc="html" width="100%" height="100%" :style="iframeStyle" />
    </div>
  </div>
</template>
<script>
import axios from "axios";

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
      width: '1440',
      iframeStyle: null,
    }
  },
  created() {
    // this.bus.$on('refresh-preview', () => {
    //   this.preview();
    // });
  },
  mounted() {
    this.preview();
  },
  computed: {
    wrapperStyle() {
      return {
        width: `${this.width}px`,
        maxWidth: '1400px',
      };
    }
  },
  methods: {
    async preview() {
      this.isLoading = true;

      try {
        const response = await axios.post(this.url, {
          title: document.querySelector('#title').value,
          abstract: document.querySelector('#abstract').value,
          content: document.querySelector('[name="content"]').value
        });
        this.html = response.data.page;
      } catch (error) {
        alert('An error occurred while fetching your preview, please try again')
      } finally {
        this.isLoading = false;
      }
    },
    setWidth(width) {
      this.width = width;
      if (width === '1920') {
        this.iframeStyle = {
          zoom: 0.75,
          '-moz-transform': 'scale(0.75)',
          '-moz-transform-origin': '0 0',
          '-o-transform': 'scale(0.75)',
          '-o-transform-origin': '0 0',
          '-webkit-transform': 'scale(0.75)',
          '-webkit-transform-origin': '0 0',
        };
      } else {
        this.iframeStyle = null;
      }
    }
  },
}
</script>
