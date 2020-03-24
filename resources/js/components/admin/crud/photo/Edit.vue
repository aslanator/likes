<template>
    <div>
        <form @submit="edit">
            <div class="form-group" v-if="id">
                <label>ID: {{id}}</label>
            </div>
            <div v-if="url" class="form-group">
                <img :src="url" alt="photo"/>
            </div>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" ref="file" @change="handleFileUpload">
                <label class="custom-file-label" for="customFile">{{ fileName ? fileName : 'Choose photo' }}</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>

<script>
    export default {
        name: "AdminPhotoEdit",
        props: ['id'],
        data() {
            return {
                url: '',
                file: '',
                fileName: '',
            }
        },
        methods: {
            handleFileUpload() {
                this.file = this.$refs.file.files[0];
                this.fileName = this.file.name
            },
            edit: function (event) {
                event.preventDefault();
                let id = this.id,
                    url,
                    method;
                if (id) {
                    method = 'patch';
                    url    = `photo/${id}`;
                } else {
                    method = 'post';
                    url    = `photo`;
                }
                var formData = new FormData();
                formData.append('_method', method);
                formData.append("photo", this.file);
                axios.post(url, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                    .then((response) => {
                        this.$notify({
                            group: 'common',
                            title: 'Saved',
                        });
                        this.url = '/' + response.data.url;
                    })
                    .catch((response) => {
                        this.$notify({
                            group: 'common',
                            title: 'Error',
                            text: response,
                        });
                    });
            }
        },
        mounted() {
            let id = this.id;
            if (id > 0)
                axios.get(`/photo/${id}`)
                    .then(response => {
                        let data = response.data;
                        this.url = '/' + data.url;
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
    .custom-file {
        margin-bottom: 10px;
    }
</style>
