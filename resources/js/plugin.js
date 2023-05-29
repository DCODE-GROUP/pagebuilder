import PageBuilderSidebar from './layouts/PageBuilderSidebar.vue';
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
import Submit from "./Submit.vue";
import Form from "./Form.vue";
import Attachment from "./Attachment.vue";
import MediaGallery from "./media-gallery/MediaGallery.vue";
import Folders from "./media-gallery/Folders.vue";
import ImageUpload from "./media-gallery/ImageUpload.vue";
import GalleryModal from "./media-gallery/GalleryModal.vue";

// import { PluginManager } from "tinymce";

import $bus from "./lib/Vue3EventBus";

import vuedraggable from "vuedraggable";
import { autoAnimatePlugin } from '@formkit/auto-animate/vue'
import seoSettingsPlugin from "~vendor/dcodegroup/seo/resources/js/plugin"

import "toastify-js/src/toastify.css"

const contentBuilderPlugin = {
    install(app, options) {
        app.provide("bus", $bus);

        app.component('draggable', vuedraggable);

        app.component('PageBuilderSidebar', PageBuilderSidebar);
        
        app.component('ContentBuilder', ContentBuilder);
        app.component('Module', Module);
        app.component('PagePreview', PagePreview);
        app.component('SelectMedia', SelectMedia);
        app.component('TitleSlug', TitleSlug);
        app.component('Selector', Selector);
        app.component('Submit', Submit);
        app.component('VForm', Form);
        app.component('Attachment', Attachment);
        app.component('MediaGallery', MediaGallery);
        app.component('Folders', Folders);
        app.component('ImageUpload', ImageUpload);

        app.component('Tooltip', Tooltip);
        app.component('Modal', Modal);
        app.component('GalleryModal', GalleryModal);

        app.use(autoAnimatePlugin);
        app.use(seoSettingsPlugin);

        // PluginManager.add('mediaGallery', (editor, url) => {
        //     editor.ui.registry.addButton('mediaGalleryButton', {
        //         icon: 'backcolor',
        //         tooltip: 'Open Media Gallery',
        //         onAction: function () {
        //             editor.windowManager.open({
        //                 title: 'Dialog Title', // The dialog's title - displayed in the dialog header
        //                 body: {
        //                     type: 'panel', // The root body type - a Panel or TabPanel
        //                     items: [ // A list of panel components
        //                         {
        //                             type: 'htmlpanel', // an HTML panel component
        //                             html: '<h1>Hello</h1>'
        //                         }
        //                     ]
        //                 },
        //                 buttons: [ // A list of footer buttons
        //                     {
        //                         type: 'submit',
        //                         text: 'OK'
        //                     }
        //                 ]
        //             });
        //         }
        //     });
        //     return {
        //         getMetadata: function () {
        //             return {
        //                 name: 'Media Gallery',
        //                 url: 'https://dcodegroup.com'
        //             };
        //         }
        //     }
        // });

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
