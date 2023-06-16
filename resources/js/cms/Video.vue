<template>
    <div>
        <div class="flex mb-4 space-x-4">
            <div class="w-1/2">
                <label class="form-label">Vimeo ID</label>
                <input 
                    type="text" 
                    class="form-input"
                    v-model="videoId"
                    @keyup="update('videoId')"
                />
            </div>
        </div>
    </div>
</template>

<script>
import Module from "../Module.vue"

export default {
    extends: Module,
    data() {
        return {
            videoId: null,
        }
    },
    mounted() {
        this.videoId = this.fields.videoId.value;
    }
}
</script>
