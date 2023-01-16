<template>
    <div>
        <h3>Heading</h3>

        <label>
            Heading
            <input type="text" v-model="heading" @keyup="update('heading')"/>
        </label>
        <label>
            Sub heading
            <input type="text" v-model="sub_heading" @keyup="update('sub_heading')"/>
        </label>

        <hr/>

        <label>
            Dark
            <input type="checkbox" v-model="dark" @change="update('dark')"/>
        </label>
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
