<template>
	<span class="relative z-50">
		<span v-auto-animate="{ duration: 100 }">
			<span v-if="tooltipIsVisible" class="absolute left-0 p-2 text-xs bg-white border border-gray-100 rounded bottom-full">
				<p class="min-w-[14rem] font-body font-normal text-black text-xs">
					<slot />
				</p>
			</span>
		</span>
		<span class="inline-block p-1" @mouseover="tooltipIsVisible = true"  @mouseleave="tooltipIsVisible = false" :class="iconclasses">
			<i class="fa-solid fa-circle-info"></i>
		</span>
	</span>
</template>

<script setup>
import { ref } from "vue"

defineProps({
	iconclasses: { type: String, required: false, default: '' },
})

const tooltipIsVisible = ref(false)
</script>