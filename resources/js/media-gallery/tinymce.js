const mediaGalleryPlugin = function (editor) {
    editor.ui.registry.addButton('mediaGalleryPlugin', {
        text: 'Insert Image',
        icon:'user',
        onAction: () => function () {
            const event = new CustomEvent('open-gallery', {
                detail: {
                    callback: (payload) => {
                        editor.insertContent("<img src='"+payload.media.url+"'>");
                    }
                }
            })
        }
    });
}

export { mediaGalleryPlugin };