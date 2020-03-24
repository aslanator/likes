<template>
    <div>
        <p class="h2">Photo</p>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Url</th>
                <th scope="col">Image</th>
                <th scope="col">Datetime</th>
                <th scope="col">Likes</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item,index) in items" @key="index">
                <th scope="row">{{item.id}}</th>
                <td>{{item.url}}</td>
                <td><img :src="'/' + item.url" alt="image"></td>
                <td>{{item.datetime}}</td>
                <td>{{item.likes_count}}</td>
                <td>
                    <router-link :to="{ name: 'admin-photo-edit', query: {id: item.id } }" class="btn btn-warning">
                        edit
                    </router-link>
                </td>
                <td>
                    <Button class="btn btn-danger" @click="del($event, item.id)">Удалить</Button>
                </td>
            </tr>
            </tbody>
        </table>
        <router-link :to="{ name: 'admin-photo-edit' }" class="btn btn-primary">add new photo</router-link>
    </div>
</template>

<script>
    export default {
        name: "AdminPhotoIndex",
        props: ['title'],
        data() {
            return {
                items: [],
            }
        },
        methods: {
            del: function ($event, id) {
                let url = `photo/${id}`;
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
            axios.get('/photo')
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
    img {
        width: 100px;
        height: 100px;
    }
</style>
