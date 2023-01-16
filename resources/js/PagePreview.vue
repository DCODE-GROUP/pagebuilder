<template>
    <button
            id="cms-page-preview"
            :class="{ loading: isLoading, 'btn btn-primary-outlined': true, 'hollow': true }"
            type="button"
            @click="preview"
            :disabled="isLoading"
    >
        <i class="fal fa-eye"></i>
        Preview
    </button>
</template>
<script>
    export default {
        props: {
            pageId: String
        },
        data() {
            return {
                isLoading: false,
                url: `/admin/pages/${this.pageId}/preview`
            }
        },
        methods: {
            preview() {
                this.isLoading = true;

                axios.put(this.url, {
                    title: document.querySelector('#title').value,
                    abstract: document.querySelector('#abstract').value,
                    content: document.querySelector('[name="content"').value
                })
                    .then(() => {
                        window.open(this.url, '_blank');
                    })
                    .catch(error => {
                        alert('An error occurred while fetching your preview, please try again')
                    })
                    .then(() => {
                        this.isLoading = false;
                    });
            }
        },
    }
</script>