import ContentBuilder from './ContentBuilder.vue';
import Module from './Module.vue';
import PagePreview from './PagePreview.vue';
import SelectMedia from './SelectMedia.vue';
import TitleSlug from './TitleSlug.vue';
import Heading from "./cms/Heading.vue"
import ImageSlider from "./cms/ImageSlider.vue"
import SingleColumn from "./cms/SingleColumn.vue"
import TwoColumn from "./cms/TwoColumn.vue"
import TwoColumnWithImage from "./cms/TwoColumnWithImage.vue"
import Selector from "./Selector.vue"
import Tooltip from "./components/Tooltip.vue"
import Modal from "./components/Modal.vue"

import $bus from "./lib/Vue3EventBus";

import vuedraggable from "vuedraggable";
import { autoAnimatePlugin } from '@formkit/auto-animate/vue'

import shadow from 'vue-shadow-dom';

const contentBuilderPlugin = {
    install(app, options) {
        app.use(shadow);
        app.provide("bus", $bus);

        app.component('draggable', vuedraggable);

        app.component('ContentBuilder', ContentBuilder);
        app.component('Module', Module);
        app.component('PagePreview', PagePreview);
        app.component('SelectMedia', SelectMedia);
        app.component('TitleSlug', TitleSlug);
        app.component('Selector', Selector);
        
        app.component('Tooltip', Tooltip);
        app.component('Modal', Modal);

        app.use(autoAnimatePlugin);

        const modules = {
            Heading,
            SingleColumn,
            ImageSlider,
            TwoColumn,
            TwoColumnWithImage,
            ...(options?.modules || {})
        };

        Object.keys(modules).forEach(key => {
            app.component(key, modules[key]);
        });
    },
};

export default contentBuilderPlugin;
