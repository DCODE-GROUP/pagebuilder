<template>
  <div class="flex flex-col items-center flex-1 ">
    <div class="flex justify-center w-full py-2">
      <div class="flex space-x-2">
        <button type="button" class="lowercase btn btn-primary-outlined" :class="{ '!bg-brand-green !text-white': width === '1920'}" @click="setWidth('1920')">1920px</button>
        <button type="button" class="lowercase btn btn-primary-outlined" :class="{ '!bg-brand-green !text-white': width === '1440'}" @click="setWidth('1440')">1440px</button>
        <button type="button" class="lowercase btn btn-primary-outlined" :class="{ '!bg-brand-green !text-white': width === '1366'}" @click="setWidth('1366')">1366px</button>
        <button type="button" class="lowercase btn btn-primary-outlined" :class="{ '!bg-brand-green !text-white': width === '768'}" @click="setWidth('768')">768px</button>
        <button type="button" class="lowercase btn btn-primary-outlined" :class="{ '!bg-brand-green !text-white': width === '375'}" @click="setWidth('375')">375px</button>
      </div>
    </div>
    <div class="w-full overflow-x-scroll border border-gray-300">
      <div class="mx-auto overflow-hidden" style="height: 720px;" :style="wrapperStyle">
          <iframe :srcdoc="html" width="100%" height="100%" :style="iframeStyle" />
      </div>
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
    this.bus.$on('refresh-preview', () => {
      this.preview();
    });
  },
  mounted() {
    this.preview();
  },
  computed: {
    wrapperStyle() {
      return {
        width: `${this.width}px`
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
        console.log(error);
        alert('An error occurred while fetching your preview, please try again')
      } finally {
        this.isLoading = false;
      }
    },
    setWidth(width) {
      this.width = width;
    }
  },
}
</script>
