<template>
	<div>
		<div class="flex pb-4 mb-4 border-b border-gray-300">
			<div class="btn-group flex flex-1">
				<button type="button" class="btn flex-1" :class="activeTab === 'first' ? 'btn-primary' : 'btn-primary-outlined'" @click="setActiveTab('first')">Page</button>
				<button type="button" class="btn flex-1" :class="activeTab === 'second' ? 'btn-primary' : 'btn-primary-outlined'" @click="setActiveTab('second')">Content</button>
			</div>
		</div>
		<div>
			<div v-show="activeTab === 'first'">
				<slot name="first" />
			</div>
			<div v-show="activeTab === 'second'">
				<slot name="second" />
			</div>
		</div>
	</div>
</template>

<script setup>
import {ref,inject} from "vue"

const activeTab = ref('first')
const props = defineProps(['page'])

const bus = inject("bus")

let page = props.page;

bus.$on("set-page", (data) => {
  page = data
})

function setActiveTab(tab) {
  if (!page.id) {
    return;
  }
	activeTab.value = tab
}
</script>
