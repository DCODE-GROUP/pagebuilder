<template>
	<div>
		<button type="button" class="btn btn-danger" @click="toggleModalVisibility">{{ buttonText }}</button>
		<Teleport to="body">
			<transition name="fade">
				<div v-if="modalIsVisible" class="fixed top-0 left-0 w-full h-full bg-black/20 z-[3000]"  @click="toggleModalVisibility"></div>
			</transition>
			<transition name="fade-from-top">
				<div v-if="modalIsVisible" class="fixed -translate-x-1/2 bg-white rounded top-10 left-1/2 z-[3001] rounded" :class="customClass">
					<button type="button" class="absolute w-10 h-10 text-error top-4 right-4" @click="toggleModalVisibility"><i class="fa-solid fa-close" /></button>
					<div class="px-8 pt-8 pb-4 ">
							<slot :toggleModalVisibility="toggleModalVisibility"/>
					</div>
				</div>
			</transition>
		</Teleport>
	</div>
</template>

<script setup>
import {inject, ref} from "vue"

defineProps({
	header: { type: String, required: false, default: '' },
	buttonText: { type: String, required: false, default: '' },
  customClass: { type: String, required: false, default: '' },
})

const bus = inject("bus")

const modalIsVisible = ref(false)

bus.$on("close-gallery", (data) => {
  modalIsVisible.value = false;
})

bus.$on("open-gallery", (data) => {
  modalIsVisible.value = true;
})

function toggleModalVisibility() {
	modalIsVisible.value = !modalIsVisible.value
}
</script>