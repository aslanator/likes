<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label for="user-name" class="col-sm-4 col-form-label text-md-right">Name</label>
                                <div class="col-md-6">
                                    <input id="user-name" type="email" class="form-control" v-model="name" required
                                           autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="email" required
                                           autofocus>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password"
                                           required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="admin" class="col-md-4 col-form-label text-md-right">I admin, trust
                                    me!</label>
                                <div class="col-md-6">
                                    <input id="admin" type="checkbox" class="form-control" v-model="admin">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" @click="handleSubmit">
                                        Register
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
    import { required, maxLength, minLength, email } from 'vuelidate/lib/validators'


    export default {
        data() {
            return {
                name: "",
                email: "",
                password: "",
                admin: false,
            }
        },
        validations: {
            name: {
                required,
                maxLength: maxLength(50),
            },
            email: {
                required,
                email,
            },
            password: {
                required,
                minLength: minLength(6),
            }
        },
        methods: {
            handleSubmit(e) {
                e.preventDefault();
                if (this.$root.validate(this.$v, this.$data)) {
                    let email    = this.email;
                    let password = this.password;
                    let name     = this.name;
                    let admin    = this.admin;
                    axios.post('/register', {
                        name: name,
                        password: password,
                        email: email,
                        is_admin: admin
                    }).then(response => {
                        let user          = response.data.user;
                        let stringifyUser = JSON.stringify(user);
                        let token         = response.data.token;
                        localStorage.setItem('likes.user', stringifyUser);
                        localStorage.setItem('likes.token', token);
                        if (localStorage.getItem('likes.token') != null) {
                            this.$emit('loggedIn');
                            this.$router.push('feed');
                        }
                    }).catch(response => {
                        this.$notify({
                            group: 'common',
                            title: 'Error',
                            text: response
                        });
                    })
                }
            },
        }
    }
</script>

<style scoped>

</style>
\
