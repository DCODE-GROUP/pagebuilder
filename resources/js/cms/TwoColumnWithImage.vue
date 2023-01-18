<template>
    <div>
        <header class="pb-2 mb-4 border-b border-gray-400">
            <h3>Two Column With Image</h3>
        </header>
        
        <div class="mb-4">
            <label class="form-label">Body</label>
            <tinymce-editor v-model="body" :init="tinyMCEConfig" @onChange="update('body')"></tinymce-editor>
        </div>
        
        <div class="flex mb-4 space-x-4">
            <div class="w-1/2">
                <label class="form-label">Image</label>
                <select-media v-model="image" @input="update('image')" :select-mobile="false" single></select-media>
            </div>
            
            <div class="w-1/2">
                <label class="form-label">Icon</label>
                <select-media v-model="icon" :select-mobile="false" label="Icon Image" @input="update('icon')" single></select-media>
            </div>
        </div>
        
        <div class="mb-4">
            <label class="form-label">Image Link</label>
            <input type="text" class="form-input" v-model="imageLink" @change="update('imageLink')"/>
        </div>
        

        <div class="mb-4">
            <label class="form-label">Anchor name (for on-page links)</label>
            <input type="text" class="form-input" v-model="anchor" @change="update('anchor')"/>
        </div>
        
        <div class="grid grid-cols-4 gap-4">
            <div class="mb-4">
                <label class="form-label">Padding</label>
                <input type="checkbox" v-model="padding" @change="update('padding')"/>
            </div>
            <div class="mb-4">
                <label class="form-label">Rounded Image?</label>
                <input type="checkbox" v-model="rounded" @change="update('rounded')"/>
            </div>
            <div>
                <label class="form-label">Style</label>
                <select class="form-input" v-model="style" @change="update('style')">
                    <option value="">Default</option>
                    <option value="dark">Dark</option>
                    <option value="boxed-white">Boxed white</option>
                </select>
            </div>
            <div>
                <label class="form-label">Image Alignment</label>
                <select class="form-input" v-model="alignment" @change="update('alignment')">
                    <option value="right">Right</option>
                    <option value="left">Left</option>
                </select>
            </div>
        </div>
        
        

    </div>
</template>

<script>
import Module from "../Module.vue"
import Editor from "@tinymce/tinymce-vue"

export default {
    extends: Module,
    data() {
        return {
            body: null,
            image: null,
            imageLink: null,
            rounded: false,
            icon: null,
            anchor: null,
            padding: true,
            style: 'dark',
            alignment: 'right'
        }
    },
    mounted() {
        this.body = this.fields.body.value;
        this.image = this.fields.image.value;
        this.imageLink = this.fields.imageLink.value;
        this.rounded = this.fields.rounded.value;
        this.icon = this.fields.icon.value;
        this.anchor = this.fields.anchor.value;
        this.padding = this.fields.padding.value;
        this.style = this.fields.style.value;
        this.alignment = this.fields.alignment.value;
    },
    components: {
        'tinymce-editor': Editor
    }
}
</script>
