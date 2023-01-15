import ContentBuilder from './ContentBuilder.vue';
import Module from './Module.vue';
import PagePreview from './PagePreview.vue';
import SelectMedia from './SelectMedia.vue';
import TitleSlug from './TitleSlug.vue';
import vuedraggable from "vuedraggable";

const contentBuilderPlugin = {
    install(app, options) {
        app.component('draggable', vuedraggable);

        app.component('ContentBuilder', ContentBuilder);
        app.component('Module', Module);
        app.component('PagePreview', PagePreview);
        app.component('SelectMedia', SelectMedia);
        app.component('TitleSlug', TitleSlug);

        Object.keys(options.modules).forEach(function(key) {
            app.component(key, options.modules[key]);
        });
    },
};

export default contentBuilderPlugin;
