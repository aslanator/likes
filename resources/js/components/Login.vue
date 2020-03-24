<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="email" required autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password" required>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" @click="handleSubmit">
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                email: "",
                password: ""
            }
        },
        methods: {
            handleSubmit(e) {
                e.preventDefault();
                if (this.password.length > 0) {
                    let email = this.email;
                    let password = this.password;
                    axios.post('/login', {email, password}).then(response => {
                        let user = response.data.user;
                        let stringifyUser = JSON.stringify(user);
                        let token = response.data.token;
                        localStorage.setItem('likes.user', stringifyUser);
                        localStorage.setItem('likes.token', token);
                        if (localStorage.getItem('likes.token') != null) {
                            this.$emit('loggedIn');
                            this.$router.push('feed');
                        }
                    }
                    ).catch(error => {
                        if(401 === error.response.status)
                            this.$notify({
                                group: 'common',
                                title: 'Error',
                                text: 'wrong login or password'
                            });
                        else
                            this.$notify({
                                group: 'common',
                                title: 'Error',
                                text: error
                            });
                    })
                }
            }
        }
    }
</script>

<style scoped>

</style>
\
