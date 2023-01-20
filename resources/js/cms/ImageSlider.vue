<template>
    <div class="image-slider-module">

        <header class="mb-4">
            <button type="button" class="btn btn-primary" @click="add">
                <i class="mr-2 fa-solid fa-plus"></i>
                Add slide
            </button>
        </header>

        <draggable
            tag="div"
            :list="items" 
            item-key="id"
            handle=".handle"
            v-auto-animate="{ duration: 100 }"
        >
            <template #item="{element, index}">
                <div class="relative p-4 pl-10 mb-4 border border-gray-300 rounded bg-gray-50 module-item -slider">
                    <div class="absolute top-0 left-0 flex items-center justify-center w-6 h-full bg-gray-300 cursor-move handle">
                        <i class="text-white fa-solid fa-align-justify"></i>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <select-media v-model="element.image" :select-mobile="false" single></select-media>
                        <select-media v-model="element.mobile_image" :select-mobile="false" label="Mobile Image" single></select-media>
                    </div>
                    <div class="module-item-options">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Caption</label>
                                <input type="text" class="form-input" v-model="element.caption"/>
                            </div>
                            <div>
                                <label class="form-label">Link</label>
                                <input type="text" class="form-input" v-model="element.link"/>
                            </div>
                            <div class="col-span-2">
                                <label class="form-label">Image Alignment</label>
                                <select class="form-input" v-model="element.alignment" @change="update('alignment')">
                                    <option value="center">Center</option>
                                    <option value="top">Top</option>
                                    <option value="bottom">Bottom</option>
                                </select>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="text-right">
                                <button type="button" class="btn btn-danger btn-sm" @click="remove(i)">
                                    <i class="mr-2 fa-regular fa-trash-can"></i>
                                    Delete
                                </button>
                            </div>
                    </div>
                </div>
            </template>
        </draggable>

        <div v-auto-animate="{ duration: 100 }">
            <footer v-if="items.length !== 0" class="grid grid-cols-4 gap-4">
                <div class="mb-4">
                    <label class="form-label" for="SliderContained">Contained</label>
                    <label class="sm-toggleable sm-switch" for="SliderContained">
                        <input type="checkbox" id="SliderContained" v-model="contained" @change="update('contained')"/>
                        <span></span>
                    </label>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="SliderMargins">Margins</label>
                    <label class="sm-toggleable sm-switch" for="SliderMargins">
                        <input type="checkbox" id="SliderMargins" v-model="margins" @change="update('margins')"/>
                        <span></span>
                    </label>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="SliderFullHeight">Full height</label>
                    <label class="sm-toggleable sm-switch" for="SliderFullHeight">
                        <input type="checkbox" id="SliderFullHeight" v-model="fullHeight" @change="update('fullHeight')"/>
                        <span></span>
                    </label>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="">Interval</label>
                    <input type="number" v-model="interval" step="1000" @keyup="update('interval')" class="form-input" />
                </div>
            </footer>
        </div>
    </div>
</template>

<script>
import Module from "../Module.vue"
import Draggable from "vuedraggable";
import { v4 as uuidv4 } from 'uuid';

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
