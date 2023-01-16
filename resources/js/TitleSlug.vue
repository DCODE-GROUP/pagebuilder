<template>
    <div class="flex mb-4 space-x-4">
        <div class="w-1/2">
            <label for="title">
                Title
                <span data-tooltip title="The title of the page displayed on the first heading.">
                    <i class="fal fa-info-circle"></i>
                </span>
            </label>
            <input id="title" name="title" type="text" v-model="title" @keyup="titleKeyUp" @blur="slugifyTitle" class="w-full">
            <span v-if="titleError" class="form-error is-visible">{{ titleError }}</span>
        </div>
        <div class="w-1/2">
            <label for="slug">
                Slug
                <span data-tooltip title="The slug is used in the page URL, this is generated from the title but can also be manually edited.">
                    <i class="fal fa-info-circle"></i>
                </span>
            </label>
            <div class="input-group">
                <div class="flex items-center">
                    <span class="mr-2">/</span>
                    <input id="slug" name="slug" type="text" class="w-full input-group-field" v-model="slug" @keyup="slugKeyUp" @blur="slugifySlug" >
                </div>
            </div>
            <span v-if="slugError" class="form-error is-visible">{{ slugError }}</span>
        </div>
    </div>
</template>
<script>
    import _ from 'lodash';

    export default {

        props: {
            setTitle: String,
            titleError: String,
            setSlug: String,
            slugError: String
        },

        data() {
            return {
                title: this.setTitle,
                slug: this.setSlug
            }
        },

        methods: {
            slugifyTitle() {
                if (this.slug !== '') {
                    return;
                }
                return this.slug = _.kebabCase(this.title);
            },
            slugifySlug() {
                return this.slug = _.kebabCase(this.slug);
            },
            titleKeyUp: _.debounce(function () {
                this.slugifyTitle();
            }, 1000),
            slugKeyUp: _.debounce(function () {
                this.slugifySlug();
            }, 1000)
        }
    }
</script>
