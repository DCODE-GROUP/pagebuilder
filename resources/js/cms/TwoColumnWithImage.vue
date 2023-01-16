<template>
    <div>
        <h3>Two Column With Image</h3>

        <label>
            Body
            <tinymce-editor v-model="body" :init="tinyMCEConfig" @onChange="update('body')"></tinymce-editor>
        </label>
        <label>
            Image
            <select-media v-model="image" @input="update('image')" :select-mobile="false"></select-media>
        </label>
        <label>
            Image Link
            <input type="text" v-model="imageLink" @change="update('imageLink')"/>
        </label>
        <label>
            Rounded Image?
            <input type="checkbox" v-model="rounded" @change="update('rounded')"/>
        </label>
        <label>
            Icon
            <select-media v-model="icon" :select-mobile="false" @input="update('icon')"></select-media>
        </label>
        <label>
            Anchor name (for on-page links)
            <input type="text" v-model="anchor" @change="update('anchor')"/>
        </label>
        <label>
            Padding
            <input type="checkbox" v-model="padding" @change="update('padding')"/>
        </label>
        <label>
            Style
            <select v-model="style" @change="update('style')">
                <option value="">Default</option>
                <option value="dark">Dark</option>
                <option value="boxed-white">Boxed white</option>
            </select>
        </label>
        <label>
            Image Alignment
            <select v-model="alignment" @change="update('alignment')">
                <option value="right">Right</option>
                <option value="left">Left</option>
            </select>
        </label>
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
