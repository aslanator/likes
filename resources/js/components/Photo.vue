<template>
    <div class="jumbotron">
        <img :src="photo.url" alt="photo"/>
        <p>likes: {{photo.likes_count}}</p>
        <button type="button" class="btn btn-danger" @click="like">
            {{ alreadyLiked ? 'Unlike!' : 'Like!' }}
        </button>
    </div>
</template>

<script>
    export default {
        name: "photo",
        props: ['propsPhoto'],
        data() {
            return {
                alreadyLiked: this.propsPhoto.liked_by_current_user.length > 0,
                photo: this.propsPhoto,
            }
        },
        methods : {
            like() {
                if (!this.alreadyLiked) {
                    let url = `like/photo/${this.photo.id}`;
                    axios.post(url)
                        .then(response => {
                            this.alreadyLiked = true;
                            if(response.data)
                                this.photo.likes_count++;
                        })
                        .catch(console.error);
                }
                else{
                    let url = `like/photo/${this.photo.id}`;
                    axios.delete(url)
                        .then(response => {
                            this.alreadyLiked = false;
                            if(response.data)
                                this.photo.likes_count--;
                        })
                        .catch(console.error);
                }
            }
        }
    }
</script>

<style scoped>
    img{
        max-width: 700px;
        max-height: 700px;
    }
</style>
