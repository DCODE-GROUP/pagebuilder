<template>
    <div class="select-media" :class="{'-single': ! selectMobile}">
        <div class="flex space-x-4 -files ">
            <div class="-file -desktop media"
                 title="1570x1000px desktop (or 575x500px) / no more than 200kb"
                 @click="openManager"
                 :class="{'!w-full':single}">
                 <div>
                     <span v-if="item" class="-clear" @click.stop="selectItem('')">x</span>
                     <h5 v-else>
                        <p>
                            <i class="fa-solid fa-plus"></i>
                        </p>
                        <p>{{ label }}</p>
                     </h5>
                 </div>
            </div>
            <div class="-file -phone media"
                 title="650x700px mobile (325x350px) / no more than 100kb"
                 @click="openManager($event, true)"
                 v-if="selectMobile"
                 :class="{'!w-full':single}">
                 <div>
                     <span v-if="mobileItem" class="-clear" @click.stop="selectItem('', true)">x</span>
                     <h5 v-else>
                        <p>
                            <i class="fa-solid fa-plus"></i>
                        </p>
                        <p>Mobile Image</p>
                     </h5>
                 </div>
            </div>
        </div>
        <input type="hidden" :name="field" :id="field" v-model="item" v-if="field"/>
        <input type="hidden" :name="'mobile_' + field" :id="'mobile_' + field" v-model="mobileItem"/>
    </div>
</template>
<script>
    export default {
        props: {
            value: String,
            mobileValue: String,
            selectMobile: {
                type: Boolean,
                default: true
            },
            single: {
                type: Boolean,
                default: false
            },
            field: {
                type: String,
                default: 'media'
            },
            label: {
                type: String,
                default: 'Desktop Image'
            },
        },
        data() {
            return {
                route: '/admin/media/manager/folder',
                item: this.value,
                mobileItem: this.mobileValue,
            }
        },
        mounted() {
            this.$nextTick(() => {
                this.item = this.value;
                this.mobileItem = this.mobileValue;
            });
        },
        methods: {

            openManager($event, selectMobile) {
                selectMobile = typeof selectMobile !== 'undefined' && selectMobile || false;
                window.open(this.route, 'Media', 'width=900,height=600');
                window.fileman_callback = (item) => {
                    // console.log(item);
                    if (typeof item !== 'undefined') {
                        this.selectItem(item.url, selectMobile);
                    }
                };
                
            },

            selectItem(item, selectMobile) {
                let cast = selectMobile ? 'mobileItem' : 'item';
                if (cast == 'mobileItem') {
                    this.mobileItem = item;
                    this.mobileValue = item;
                } else {
                    this.item = item;
                }
                this.$emit('input', item);
            }
        },
        computed: {
            imgSrc() {
                return this.item;
                return this.item ? this.item : '/img/placeholder/grey.png';
            }
        }
    }
</script>

<style lang="postcss" scoped>
.media {
    @apply inline-flex items-center justify-center w-1/2 h-40 border rounded-lg text-center;
    @apply cursor-pointer transition-colors;
}
</style>