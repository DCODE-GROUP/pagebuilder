<template>
    <div>
        <header class="pb-2 mb-4 border-b border-gray-400">
            <h3>Two Column</h3>
        </header>

        <div class="mb-4">
            <label class="form-label">Heading</label>
            <input type="text" class="form-input" v-model="heading" @keyup="update('heading')"/>
        </div>
        
        <div class="flex mb-4 space-x-4">
            <div class="w-1/2">
                <label class="form-label">First column content</label>
                <tinymce-editor v-model="body_one" :init="tinyMCEConfig" @onChange="update('body_one')"></tinymce-editor>
            </div>
            <div class="w-1/2">
                <label class="form-label">Second column content</label>
                <tinymce-editor v-model="body_two" :init="tinyMCEConfig" @onChange="update('body_two')"></tinymce-editor>
            </div>
        </div>
        
        <div class="flex">
            <input type="checkbox" v-model="padding" @change="update('padding')"/>
            <label class="ml-2 form-label">Padding</label>
        </div>
    </div>
</template>

<script>
import Module from "../Module.vue"
import Editor from "@tinymce/tinymce-vue"

export default {
    extends: Module,
    components: {
        "tinymce-editor": Editor
    },
    data() {
        return {
            heading: null,
            body_one: null,
            body_two: null,
            padding: false
        }
    },
    mounted() {
        this.heading = this.fields.heading.value;
        this.body_one = this.fields.body_one.value;
        this.body_two = this.fields.body_two.value;
        this.padding = this.fields.padding.value;
    }
}
</script>
