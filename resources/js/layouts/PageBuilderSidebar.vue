<template>
	<div>
		<div class="flex pb-4 mb-4 border-b border-gray-300">
			<div class="btn-group flex flex-1 space-x-2">
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
import {ref} from "vue"

const activeTab = ref('first')

function setActiveTab(tab) {
	activeTab.value = tab
}
</script>
