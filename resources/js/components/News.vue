<template>
    <div class="jumbotron">
        <p class="h3">{{news.name}}</p>
        <p>{{news.text}}</p>
        <p>likes: {{news.likes_count}}</p>
        <button type="button" class="btn btn-danger" @click="like">
            {{ alreadyLiked ? 'Unlike!' : 'Like!' }}
        </button>
    </div>
</template>

<script>
    export default {
        name: "News",
        props: ['propsNews'],
        data() {
            return {
                alreadyLiked: this.propsNews.liked_by_current_user.length > 0,
                news: this.propsNews,
            }
        },
        methods : {
            like() {
                if (!this.alreadyLiked) {
                    let url = `like/news/${this.news.id}`;
                    axios.post(url)
                    .then(response => {
                        this.alreadyLiked = true;
                        if(response.data)
                            this.news.likes_count++;
                    })
                    .catch(console.error);
                }
                else{
                    let url = `like/news/${this.news.id}`;
                    axios.delete(url)
                        .then(response => {
                            this.alreadyLiked = false;
                            if(response.data)
                                this.news.likes_count--;
                        })
                        .catch(console.error);
                }
            }
        }
    }
</script>

<style scoped>

</style>
