<template>
    <div>
        <h3>Single Column</h3>

        <label>
            Sub heading
            <input type="text" v-model="sub_heading" @keyup="update('sub_heading')"/>
        </label>
        <label>
            Heading
            <input type="text" v-model="heading" @keyup="update('heading')"/>
        </label>
        <label>
            Body
            <tinymce-editor v-model="body" :init="tinyMCEConfig" @onChange="update('body')"></tinymce-editor>
        </label>

        <hr/>

        <label>
            Padding
            <input type="checkbox" v-model="padding" @change="update('padding')"/>
        </label>
    </div>
</template>

<script>
import Editor from "@tinymce/tinymce-vue"
import Module from "../Module.vue";

export default {
    extends: Module,
    components: {
        "tinymce-editor": Editor
    },
    data() {
        return {
            sub_heading: null,
            heading: null,
            body: null,
            padding: false
        }
    },
    mounted() {
        this.sub_heading = this.fields.sub_heading.value;
        this.heading = this.fields.heading.value;
        this.body = this.fields.body.value;
        this.padding = this.fields.padding.value;
    }
}
</script>
