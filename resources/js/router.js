import VueRouter from 'vue-router';

import Login from './views/common/Login.vue';
import Registration from './views/common/Register.vue';
import About from './views/common/About.vue';

export default new VueRouter({
    mode: 'history',
    base: __dirname,
    routes: [
        {
            name:"about",
            path:"/",
            component:About,
            props:false,
            meta:{
                title:"About",
                forAuth:false,
            }
        },
        {
            name:"login",
            path:"/login",
            component:Login,
            props:false,
            meta:{
                title:"Login",
                forAuth:false,
            }
        },
        {
            name:"registration",
            path:"/registration",
            component:Registration,
            props:false,
            meta:{
                title:"Registration",
                forAuth:false,
            }
        },
    ]

});
