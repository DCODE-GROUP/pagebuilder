<template>
    <div class="image-slider-module">
        <h3>Image Slider</h3>

        <draggable
            tag="div"
            :list="items"
            handle=".handle"
        >
            <div class="module-item -slider" v-for="(o, i) in items" :key="o.id">
                <div class="handle"></div>
                <div class="-images">
                    <select-media v-model="o.image" :select-mobile="false"></select-media>
                    <select-media v-model="o.mobile_image" :select-mobile="false" label="Mobile Image"></select-media>
                </div>
                <div class="module-item-options">
                    <label>
                        Caption
                        <input type="text" v-model="o.caption"/>
                    </label>
                    <label>
                        Link
                        <input type="text" v-model="o.link"/>
                    </label>
                    <label>
                        Image Alignment
                        <select v-model="o.alignment" @change="update('alignment')">
                            <option value="center">Center</option>
                            <option value="top">Top</option>
                            <option value="bottom">Bottom</option>
                        </select>
                    </label>
                    <button type="button" class="button tiny" @click="remove(i)">
                        <i class="fal fa-trash"></i>
                        Delete
                    </button>
                </div>
            </div>
        </draggable>

        <button type="button" class="button tiny" @click="add">
            <i class="fal fa-plus"></i>
            Add slide
        </button>

        <hr/>

        <label>
            Interval
            <input type="number" v-model="interval" step="1000" @keyup="update('interval')"/>
        </label>
        <label>
            Contained
            <input type="checkbox" v-model="contained" @change="update('contained')"/>
        </label>
        <label>
            Margins
            <input type="checkbox" v-model="margins" @change="update('margins')"/>
        </label>
        <label>
            Full height
            <input type="checkbox" v-model="fullHeight" @change="update('fullHeight')"/>
        </label>
    </div>
</template>

<script>
import Module from "../Module.vue"
import Draggable from "vuedraggable";

export default {
    extends: Module,
    components: {
        Draggable,
    },
    data() {
        return {
            items: [],
            interval: 5000,
            contained: true,
            margins: true,
            fullHeight: false
        }
    },
    mounted() {
        this.items = this.fields.items.value;
        this.interval = this.fields.interval.value;
        this.contained = this.fields.contained.value;
        this.margins = this.fields.margins.value;
        this.fullHeight = this.fields.fullHeight.value;
    },

    methods: {
        add() {
            this.items.push({
                id: uuidv4(),
                image: null,
                mobile_image: null,
                caption: null,
                link: null
            })
        },
        remove(i) {
            this.items.splice(i, 1);
        }
    }
}
</script>
