import { mediaGalleryPlugin } from '../media-gallery/tinymce.js';

const config = {
    plugins: "mediaGalleryPlugin",
    setup: function () {
        window.tinymce.PluginManager.add('mediaGalleryPlugin', mediaGalleryPlugin);
    }
}

export default { config };