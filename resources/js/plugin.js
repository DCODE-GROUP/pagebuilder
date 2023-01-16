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

import vuedraggable from "vuedraggable";

const contentBuilderPlugin = {
    install(app, options) {
        app.component('draggable', vuedraggable);

        app.component('ContentBuilder', ContentBuilder);
        app.component('Module', Module);
        app.component('PagePreview', PagePreview);
        app.component('SelectMedia', SelectMedia);
        app.component('TitleSlug', TitleSlug);

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
