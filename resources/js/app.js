import Vue from 'vue';
import VueRouter from 'vue-router';
import router from './router';
import App from './App.vue';
import Common from './components/Common.vue';
import Auth from './packages/auth/auth';
import User from './packages/user';
import VueI18n from 'vue-i18n';
import BootstrapVue from 'bootstrap-vue';


import {systemRu,systemEn} from "./i18n";           // import localization to front-end
require('./bootstrap');

window.Vue = require('vue');


import modal from "./components/Modal.vue"
// global data
Vue.use(Auth);
Vue.use(User);
Vue.use(VueRouter);
Vue.use(VueI18n);
Vue.use(BootstrapVue);
Vue.component('modal', modal);

import '../sass/app.scss'

router.beforeEach((to, from, next) => {
    document.title = to.meta.title + ' - Alumnitracker';
    if (to.meta.forAuth) {
        if (Vue.auth.isAuthenticated()) {
            next();
        } else {
            next({
                path: '/login'
            });
        }
    } else if (to.meta.forVisitors) {
        if (Vue.auth.isAuthenticated()) {
            next({path:"/profile"})
        } else {
            next();
        }
    }
    next();
});
const messages={
    ru:{
        system:systemRu
    },
    en:{
        system:systemEn
    }
};
const i18n = new VueI18n({
    locale: 'en',               // set locale
    messages:messages           // set locale messages
});

const common = Vue.prototype.$common = new Vue(Common).$mount();
document.body.appendChild(common.$el);
import {get} from "./api"
new Vue({
    el: '#app',
    data() {
        return {
            user: '',
            userReady: false,
            loading:false
        };
    },
    methods:{
        userInit(afterLogin = false) {
            let _this = this;
            if (_this.$auth.isAuthenticated()) {
                this.loading=true;
                get(_this, '/api/user', {}, function (response) {
                    if(response && response.data &&response.data.id){
                        var account = response.data;
                    }
                    _this.setAccount(account, afterLogin);
                }, function () {

                });
            }
        },
        setAccount(account, afterLogin) {
            this.$user.data = account;
            this.user = this.$user;
            this.userReady = this.ready = true;
            if (afterLogin) {
                this.afterLogin(this.user);
            }
            this.loading=false;
        },
        afterLogin(user) {
            if(user.isAdministrator()){
                this.$router.push("/dashboard");
            }
            else{
                this.$router.push("/profile");
            }
        }
    },
    mounted() {
        this.userInit();
    },
    router: router,
    i18n:i18n,
    render: app => app(App)
});
