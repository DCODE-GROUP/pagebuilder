<template>
	<div>
		<div class="flex pb-4 mb-4 space-x-4 border-b border-gray-300">
			<button type="button" class="btn" :class="activeTab === 'first' ? 'btn-primary' : 'btn-primary-outlined'" @click="setActiveTab('first')">Page</button>
			<button type="button" class="btn" :class="activeTab === 'second' ? 'btn-primary' : 'btn-primary-outlined'" @click="setActiveTab('second')">Content</button>
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