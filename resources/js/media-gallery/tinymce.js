const mediaGalleryPlugin = function (editor) {
    editor.ui.registry.addButton('mediaGalleryPlugin', {
        text: 'My Custom Button',
        icon:'user',
        onAction: () => function () {
            const event = new CustomEvent('open-gallery', {
                callback: (payload) => {
                    return payload.media.url;
                }
            })
        }
    });
}

export { mediaGalleryPlugin };