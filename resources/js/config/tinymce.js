import { mediaGalleryPlugin } from '../media-gallery/tinymce.js';

const config = {
    plugins: "mediaGalleryPlugin lists advlist autolink lists link image charmap preview anchor pagebreak",
    toolbar: "mediaGalleryPlugin | undo redo | bold italic | alignleft aligncenter alignright | numlist bullist | image",
    selector: 'textarea.wysiwyg',
    images_file_types: 'jpg,svg,webp,png,jpeg,gif',
    rel_list: [
        { title: 'No Referrer', value: 'noreferrer' },
        { title: 'No Follow', value: 'nofollow' },
        { title: 'External Link', value: 'external' }
    ],
    setup: function () {
        window.tinymce.PluginManager.add('mediaGalleryPlugin', mediaGalleryPlugin);
    }
}

export default { config };