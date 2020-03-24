<template>
    <div>
        <form @submit="edit">
            <div class="form-group" v-if="id">
                <label>ID: {{id}}</label>
            </div>
            <div class="form-group">
                <label for="newsName">Name</label>
                <input type="text" class="form-control" id="newsName" placeholder="Enter news title" v-model="name">
            </div>
            <div class="form-group">
                <label for="newsSlug">Slug</label>
                <input type="text" class="form-control" id="newsSlug" placeholder="Enter news slug" v-model="slug">
            </div>
            <div class="form-group">
                <label for="newsText">Text</label>
                <textarea class="form-control" id="newsText" rows="3" v-model="text"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>

<script>
    import { required, maxLength, alphaNum } from 'vuelidate/lib/validators'

    export default {
        name: "AdminNewsEdit",
        props: ['id'],
        data() {
            return {
                name: '',
                slug: '',
                text: '',
            }
        },
        validations: {
            name: {
                required,
                maxLength: maxLength(255),
            },
            text: {
                required,
            },
            slug: {
                required,
                maxLength: maxLength(255),
                alphaNum: alphaNum,
            }
        },
        methods: {
            edit: function (event) {
                event.preventDefault();
                if (!this.$root.validate(this.$v, this.$data))
                    return false;
                let id = this.id,
                    url,
                    method;
                if (id) {
                    method = 'patch';
                    url    = `news/${id}`;
                } else {
                    method = 'post';
                    url    = `news`;
                }
                axios[method](url, {
                    name: this.name,
                    slug: this.slug,
                    text: this.text,
                })
                    .then(() => {
                        this.$notify({
                            group: 'common',
                            title: 'Saved',
                        });
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
            let id = this.id;
            if (id > 0)
                axios.get(`/news/${id}`)
                    .then(response => {
                        let data  = response.data;
                        this.name = data.name;
                        this.slug = data.slug;
                        this.text = data.text;
                    })
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
