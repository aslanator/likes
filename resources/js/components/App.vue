<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <router-link :to="{path: '/'}" class="navbar-brand">Likes</router-link>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <router-link :to="{ name: 'login' }" class="nav-link" v-if="!isLoggedIn">Login</router-link>
                        <router-link :to="{ name: 'register' }" class="nav-link" v-if="!isLoggedIn">Register</router-link>
                        <router-link :to="{ path: '/admin/' }" class="nav-link" v-if="isLoggedIn && user_type == 1 && !isAdminPage">To admin panel</router-link>
                        <router-link :to="{ name: 'feed' }" class="nav-link" v-if="isLoggedIn && user_type == 1 && isAdminPage">To feed</router-link>
                        <li class="nav-link" v-if="isLoggedIn" @click="logout">Logout</li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <router-view @loggedIn="change"></router-view>
        </main>
        <notifications group="common" />
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: null,
                user_type: 0,
                isLoggedIn: localStorage.getItem('likes.token') != null
            }
        },
        mounted() {
            this.setDefaults()
        },
        computed: {
            isAdminPage() {

                return this.$route.meta && this.$route.meta.admin;
            },
        },
        methods : {
            setDefaults() {
                if (this.isLoggedIn) {
                    try{
                        let user = JSON.parse(localStorage.getItem('likes.user'));
                        this.name = user.name;
                        this.user_type = user.is_admin;
                    }
                    catch{
                        this.isLoggedIn = false
                    }
                }
            },
            change() {
                this.isLoggedIn = localStorage.getItem('likes.token') != null
                this.setDefaults()
            },
            logout(){
                localStorage.removeItem('likes.token');
                localStorage.removeItem('likes.user');
                this.change();
                this.$router.push('/');
            }
        }
    }
</script>

<style scoped>
    .nav-link{
        cursor: pointer;
    }
</style>
