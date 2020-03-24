import Login from './components/Login';
import Register from './components/Register';
import Feed from './components/Feed';
import Admin from './components/admin/Admin';
import App from './components/App';
import VueRouter from 'vue-router';
import Notifications from 'vue-notification'
import Vuelidate from 'vuelidate'

require('./bootstrap');

window.Vue = require('vue');

Vue.use(Vuelidate);
Vue.use(VueRouter);
Vue.use(Notifications);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'login',
            component: Login
        },
        {
            path: '/register',
            name: 'register',
            component: Register
        },
        {
            path: '/feed',
            name: 'feed',
            component: Feed
        },
        {
            path: '/admin/*',
            name: 'admin',
            component: Admin,
            meta: {
                admin: true
            },
        },
    ],
});

router.beforeEach(function (to, from, next) {
    let user;
    try {
        user = JSON.parse(localStorage.getItem('likes.user'));
    } catch (exception) {
        //bad json
    }
    if (to.meta.admin && (!user || !user.is_admin))
        next('/');
    next();
});

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    data: {
        apiUrl: 'api/v1',
    },
    methods: {
        validate($v, $data) {
            $v.$touch();
            if ($v.$error) {
                for (let dataKey of Object.keys($data)) {
                    let validateObject = $v[dataKey];
                    this.checkMaxLength(dataKey, validateObject);
                    this.checkMinLength(dataKey, validateObject);
                    this.checkRequired(dataKey, validateObject);
                    this.checkAlpaNum(dataKey, validateObject);
                    this.checkEmail(dataKey, validateObject);
                }
                return false;
            }
            return true;
        },
        checkMaxLength(name, validateObject) {
            if (validateObject && validateObject.maxLength === false) {
                let maxLength = validateObject.$params.maxLength.max;
                this.$notify({
                    group: 'common',
                    title: 'Error',
                    text: `Max length of ${name} should not exceed ${maxLength} characters`,
                });
            }
        },
        checkRequired(name, validateObject) {
            if (validateObject && validateObject.required === false) {
                this.$notify({
                    group: 'common',
                    title: 'Error',
                    text: `Field ${name} is required`,
                });
            }
        },
        checkMinLength(name, validateObject) {
            if (validateObject && validateObject.minLength === false) {
                let minLength = validateObject.$params.minLength.min;
                this.$notify({
                    group: 'common',
                    title: 'Error',
                    text: `Field ${name} should be at least ${minLength} character`,
                });
            }
        },
        checkAlpaNum(name, validateObject) {
            if (validateObject && validateObject.alphaNum === false) {
                this.$notify({
                    group: 'common',
                    title: 'Error',
                    text: `Field ${name} should contain only numbers and letters of the Latin alphabet`,
                });
            }
        },
        checkEmail(name, validateObject) {
            if (validateObject && validateObject.email === false) {
                this.$notify({
                    group: 'common',
                    title: 'Error',
                    text: `Field ${name} must be a valid email`,
                });
            }
        },
    }
});
