const mediaGalleryPlugin = function (editor) {

    editor.ui.registry.addButton('mediaGalleryPlugin', {
        text: 'Insert Image',
        icon: 'upload',
        onAction: () => {
            const event = new CustomEvent('open-gallery', {
                detail: {
                    callback: (payload) => {
                        editor.insertContent("<img src='"+payload.media.url+"'>");
                    }
                }
            })
            window.dispatchEvent(event);
        }
    });
}

export { mediaGalleryPlugin };