import VueRouter from 'vue-router';

import Login from './views/common/Login.vue';
import About from './views/common/About.vue';
import Dashboard from  './views/common/Dashboard.vue';

import AlumniList from "./views/alumni/List.vue";
import AlumniItem from "./views/alumni/Item.vue";

import AdministrationList from "./views/administrators/List.vue";
import AdministrationItem from "./views/administrators/Item.vue";

import UniversitiesList  from "./views/university/List.vue";
import UniversitiesItem  from "./views/university/Item.vue";

import CountriesList from "./views/country/List.vue";
import CountriesItem from "./views/country/Item.vue";

import DepartmentsList from "./views/departments/List.vue";

import CompaniesList from "./views/companies/List.vue";
import CompaniesItem from "./views/companies/Item.vue";

import Profile from "./views/alumni_page/profile.vue";

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
                forVisitors:true,
            }
        },
        {
            name:"companies",
            path:"/companies",
            component:CompaniesList,
            props:false,
            meta:{
                title:"Companies",
                forVisitors:false,
            }
        },
        {
            name:"company",
            path:"/companies/:id",
            component:CompaniesList,
            props:true,
            meta:{
                title:"Company",
                forVisitors:false,
            }
        },
        {
            name:"login",
            path:"/login",
            component:Login,
            props:false,
            meta:{
                title:"Login",
                forVisitors:true,
            }
        },
        {
            name:"dashboard",
            path:"/dashboard",
            component:Dashboard,
            props:false,
            meta:{
                title:"Dashboard",
                forAuth:true,
            }
        },
        {
            name:"profile",
            path:"/profile/:id",
            component:Profile,
            props:true,
            meta:{
                title:"Profile",
                forAuth:true,
            }
        },
        {
            name:"alumni-list",
            path:"/alumni",
            component:AlumniList,
            props:false,
            meta:{
                title:"Alumni",
                forAuth:true,
            }
        },
        {
            name:"alumni-item",
            path:"/alumni/:id",
            component:AlumniItem,
            props:true,
            meta:{
                title:"Alumni",
                forAuth:true,
            }
        },
        {
            name:"administrators",
            path:"/administrators",
            component:AdministrationList,
            props:false,
            meta:{
                title:"Administration",
                forAuth:true,
            }
        },
        {
            name:"administrator",
            path:"/administrators/:id",
            component:AdministrationItem,
            props:true,
            meta:{
                title:"Administration",
                forAuth:true,
            }
        },
        {
            name:"universities",
            path:"/universities",
            component:UniversitiesList,
            props:false,
            meta:{
                title:"Universities",
                forAuth:true,
            }
        },
        {
            name:"university",
            path:"/universities/:id",
            component:UniversitiesItem,
            props:true,
            meta:{
                title:"University",
                forAuth:true,
            }
        },
        {
            name:"country",
            path:"/countries/:id",
            component:CountriesItem,
            props:true,
            meta:{
                title:"Country",
                forAuth:true,
            }
        },
        {
            name:"countries",
            path:"/countries",
            component:CountriesList,
            props:false,
            meta:{
                title:"Countries",
                forAuth:true,
            }
        },
        {
            name:"departments",
            path:"/departments",
            component:DepartmentsList,
            props:false,
            meta:{
                title:"Departments",
                forAuth:true
            }
        }

    ]

});
