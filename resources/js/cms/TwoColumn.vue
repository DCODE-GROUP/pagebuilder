<template>
    <div>
        <h3>Two Column</h3>

        <label>
            Heading
            <input type="text" v-model="heading" @keyup="update('heading')"/>
        </label>
        <label>
            First column content
            <tinymce-editor v-model="body_one" :init="tinyMCEConfig" @onChange="update('body_one')"></tinymce-editor>
        </label>
        <label>
            Second column content
            <tinymce-editor v-model="body_two" :init="tinyMCEConfig" @onChange="update('body_two')"></tinymce-editor>
        </label>

        <hr/>

        <label>
            Padding
            <input type="checkbox" v-model="padding" @change="update('padding')"/>
        </label>
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
