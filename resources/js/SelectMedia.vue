<template>
    <div class="select-media" :class="{'-single': ! selectMobile}">
        <div class="-files">
            <div class="-file -desktop"
                 title="1570x1000px desktop (or 575x500px) / no more than 200kb"
                 @click="openManager"
                 :class="{'-set':item}">
                <span class="-icon">
                    <i class="fal fa-desktop"></i>
                </span>
                <span v-if="item" class="-clear" @click.stop="selectItem('')">
                    <i class="fal fa-times"></i>
                </span>
                <h4 v-if="! item">
                    <i class="fal fa-plus"></i><br>
                    <span>{{ label }}</span>
                </h4>
            </div>
            <div class="-file -phone"
                 title="650x700px mobile (325x350px) / no more than 100kb"
                 @click="openManager($event, true)"
                 v-if="selectMobile"
                 :class="{'-set':mobileItem}">
                <span class="-icon">
                    <i class="fal fa-mobile-android"></i>
                </span>
                <span v-if="mobileItem" class="-clear" @click.stop="selectItem('', true)">
                    <i class="fal fa-times"></i>
                </span>
                <h4 v-if="! mobileItem">
                    <i class="fal fa-plus"></i><br>
                    <span>Mobile Image</span>
                </h4>
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