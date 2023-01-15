<template>
    <div>
        <v-select
                v-model="selected"
                @input="$emit('input', emitData)"
                :value="initial"
                :placeholder="placeholder"
                :multiple="multiple"
                :options="localOptions"
                :label="label"
                @search="fetchOptions"
        />
        <input type="hidden" :id="name" :name="name" :value="value"/>
    </div>
</template>

<script>
    import vSelect from 'vue-select-3';
    import _ from 'lodash'

    export default {
        components: {
            vSelect
        },
        props: {
            name: String,
            initial: [String, Array, Number],
            placeholder: {
                type: String,
                default: 'Search ...',
            },
            multiple: Boolean,
            options: {
                type: Array,
                default: () => {
                    return []
                }
            },
            label: {
                type: String,
                default: 'label',
            },
            valueKey: {
                type: String,
                default: 'code',
            },
            endpoint: {
                type: String,
                default: null
            }
        },
        data() {
            return {
                selected: null,
                localOptions: this.options
            }
        },
        mounted() {
            if (this.initial && this.endpoint) {
                const ids = ['string', 'number'].includes(typeof this.initial) ? [this.initial] : this.initial.map((o) => o[this.valueKey] ?? o);
                if (!ids.length) {
                    return;
                }
                this.findByIds(ids.toString()).then(({data}) => {
                    this.localOptions = data
                    if (typeof this.initial === 'object' && this.multiple) {
                        return this.selected = this.localOptions;
                    }

                    this.selected = _.find(this.localOptions, (o) => {
                        return o[this.valueKey] === parseInt(this.initial);
                    });
                })

                return;
            }

            if (['string', 'number'].includes(typeof this.initial)) {
                this.selected = _.find(this.options, (o) => {
                    return o[this.valueKey] == this.initial;
                })
            }

            if (typeof this.initial === 'object' && this.multiple) {
                this.selected = this.initial;
            }

            if (!this.options.length) {
                this.fetchOptions(null);
            }
        },
        computed: {
            value() {
                if (typeof this.selected === 'undefined' || !this.selected) {
                    return '';
                }

                return typeof this.selected === 'object' && this.multiple
                    ? JSON.stringify(this.selected) : this.selected[this.valueKey];
            },
            emitData() {
                if (typeof this.selected === 'undefined' || !this.selected) {
                    return ''
                }

                if (!this.multiple) {
                    return this.selected[this.valueKey]
                }

                if (Array.isArray(this.selected)) {
                    return this.selected.map(o => o[this.valueKey])
                }

                return this.selected ;
            }
        },
        methods: {
            debouncer: _.debounce(callback => callback(), 500),

            findByIds(ids) {
                return axios.get(this.endpoint+ `?ids=${ids}`)
            },

            fetchOptions(query) {
                if (!this.endpoint) {
                    return;
                }

                this.debouncer(() => {
                    axios.get(this.endpoint+ `?s=${query}`).then(({data}) => {
                        this.localOptions = data
                    })
                });
            },
        }
    }
</script>