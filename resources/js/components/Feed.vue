<template>
    <div>
        <div class="container-fluid hero-section d-flex align-content-center justify-content-center flex-wrap ml-auto">
            <h2 class="title">Likes World</h2>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12" v-for="(item,index) in items" @key="index">
                    <News v-if="item.type === 'news'" v-bind:propsNews="item.data" v-bind:key="item.id"/>
                    <Photo v-if="item.type === 'photo'" v-bind:propsPhoto="item.data" v-bind:key="item.id"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import News from './News';
    import Photo from './Photo';

    export default {
        name: "Feed",
        data() {
            return {
                items: [],
                news: [],
                photos: [],
            }
        },
        components: {
            News,
            Photo
        },
        methods: {
            addItems: function (items, type) {
                for (let item of items) {
                    if (typeof item.datetime !== 'undefined')
                        this.items.push({
                            'type': type,
                            'data': item,
                        });
                }
            }
        },
        mounted() {
            axios.get('/news')
                .then(response => this.news = Object.values(response.data))
                .then(
                    () => axios.get('/photo')
                )
                .then(response => {
                    this.photos = Object.values(response.data)
                })
                .then(() => {
                    this.items = [];
                    this.addItems(this.news, 'news');
                    this.addItems(this.photos, 'photo');
                    this.items = this.items.sort(function (a, b) {
                        let keyA = new Date(a.data.datetime),
                            keyB = new Date(b.data.datetime);
                        if (keyA < keyB) return 1;
                        if (keyA > keyB) return -1;
                        return 0;
                    });
                })
                .catch(() => this.$router.push('/'));

        }
    }
</script>

<style scoped>

</style>
