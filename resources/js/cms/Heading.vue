<template>
    <div>
        <div class="flex mb-4 space-x-4">
            <div class="w-1/3">
                <label class="form-label">Heading</label>
                <input 
                    type="text" 
                    class="form-input"
                    v-model="heading" 
                    @keyup="update('heading')"
                />
            </div>
            <div class="w-1/3">
                <label class="form-label">Sub heading</label>
                <input 
                    type="text" 
                    class="form-input"
                    v-model="sub_heading" 
                    @keyup="update('sub_heading')"
                />
            </div>
        </div>
        <div class="flex">
            <input type="checkbox" v-model="dark" @change="update('dark')"/>
            <label class="ml-2 form-label">Dark</label>
        </div>
    </div>
</template>

<script>
import Module from "../Module.vue"

export default {
    extends: Module,
    data() {
        return {
            heading: null,
            sub_heading: null,
            dark: false
        }
    },
    mounted() {
        this.heading = this.fields.heading.value;
        this.sub_heading = this.fields.sub_heading.value;
        this.dark = this.fields.dark.value;
    }
}
</script>
