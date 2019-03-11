import Vue from 'vue';
import Chart from 'chart.js';
import VueRouter from 'vue-router';
import router from './router';
import App from './App.vue';
import Common from './components/Common.vue';
import Auth from './packages/auth/auth';
import User from './packages/user';
import VueI18n from 'vue-i18n';
import BootstrapVue from 'bootstrap-vue';
import VueChartkick from 'vue-chartkick'


import {systemRu,systemEn,alumniEn,alumniRu,administratorsEn,administratorsRu} from "./i18n";           // import localization to front-end
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
Vue.use(VueChartkick, {adapter: Chart});
import '../sass/app.scss'

router.beforeEach((to, from, next) => {
    console.log(Vue.user);
    document.title = to.meta.title + ' - Alumnitracker';
    if (to.meta.forAuth) {
        if (Vue.auth.isAuthenticated()) {
            if(to.meta.forAdmin && Vue.user.isAdministrator())return next();
            if(to.meta.forAlumni && Vue.user.isAlumni())return next();
            else if(to.meta.forAlumni) return next({path:"/no_access"});
            else if(to.meta.forAdmin) return next({path:"/no_access"});
            return next();
        }
        return next({path: '/login'});
    } else if (to.meta.forVisitors) {
        if (Vue.auth.isAuthenticated())return next({path:"/dashboard"})
        return next();
    }
    return next();
});
const messages={
    ru:{
        system:systemRu,
        alumni:alumniRu,
        administrators:administratorsRu
    },
    en:{
        system:systemEn,
        alumni:alumniEn,
        administrators:administratorsEn
    }
};


const common = Vue.prototype.$common = new Vue(Common).$mount();
document.body.appendChild(common.$el);
const i18n = new VueI18n({
    locale: 'en',               // set locale
    messages:messages           // set locale messages
});
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
            this.$i18n.locale=this.user.data.locale;
            this.userReady = this.ready = true;
            if (afterLogin) {
                this.afterLogin(this.user);
            }
            this.loading=false;
        },
        afterLogin(user) {
            console.log(">>",user);
            if(user.isAdministrator()){
                console.log("admin")
                this.$router.push("/dashboard");
            }
            else{
                console.log("al");
                this.$router.push("/profile/"+user.data.id);
            }
        },
        getAvailableGraduationYears(){
            var today = new Date().getFullYear();
            console.log(today);
            let years=[];
           while(today>=2015){
               years.push(today);
               today=today-1;
           }
           return years;

        }
    },
    mounted() {
        this.userInit();
    },
    router: router,
    i18n:i18n,
    render: app => app(App)
});
