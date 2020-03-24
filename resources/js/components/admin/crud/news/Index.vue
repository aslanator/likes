<template>
    <div>
        <p class="h2">News</p>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Name</th>
                <th scope="col">Slug</th>
                <th scope="col">Datetime</th>
                <th scope="col">likes</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item,index) in items" @key="item.id">
                <th scope="row">{{item.id}}</th>
                <td>{{item.name}}</td>
                <td>{{item.slug}}</td>
                <td>{{item.datetime}}</td>
                <td>{{item.likes_count}}</td>
                <td>
                    <router-link :to="{ name: 'admin-news-edit', query: {id: item.id } }" class="btn btn-warning">edit
                    </router-link>
                </td>
                <td>
                    <Button class="btn btn-danger" @click="del($event, item.id)">Удалить</Button>
                </td>
            </tr>
            </tbody>
        </table>
        <router-link :to="{ name: 'admin-news-edit' }" class="btn btn-primary">add new news</router-link>
    </div>
</template>

<script>
    export default {
        name: "AdminNewsIndex",
        props: ['title'],
        data() {
            return {
                items: [],
            }
        },
        methods: {
            del: function ($event, id) {
                let url = `news/${id}`;
                axios.delete(url)
                    .then(() => {
                        this.$notify({
                            group: 'common',
                            title: 'Deleted',
                        });
                        this.items = this.items.filter(item => item.id != id);
                    })
                    .catch((response) => {
                        this.$notify({
                            group: 'common',
                            title: 'Error',
                            text: response,
                        });
                    });
            },
        },
        mounted() {
            axios.get('/news')
                .then(response => this.items = Object.values(response.data))
                .catch((response) => {
                    this.$notify({
                        group: 'common',
                        title: 'Error',
                        text: response
                    });
                });

        }
    }
</script>

<style scoped>

</style>
