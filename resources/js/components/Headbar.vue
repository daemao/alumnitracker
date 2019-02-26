<template>
    <nav class="navbar fixed-top navbar-dark bg-primary ">
            <router-link class="navbar-brand" :to="{ name: 'home' }">Alumnitracker</router-link>
            <div class="headbar-left">
                <div style="margin-right:40px;">
                    <span :class="{'navbar-muted':$i18n.locale==='en'}" @click="changeLocale('en')">En</span>
                    <span :class="{'navbar-muted':$i18n.locale==='ru'}" @click="changeLocale('ru    ')">Ru</span>
                </div>
                <div class="headbar-exit" @click="logout"> </div>
            </div>
    </nav>
</template>
<script>
    import {post} from "../api";

    export default {
        methods:{
            logout() {
                this.$auth.destroyToken();
                this.$router.push({name: "login"});
                this.$root.user = "";
            },
            changeLocale(el){
                let _this=this;
                post(_this,"/api/change-locale",{locale:el},
                    (res)=>{
                        _this.$i18n.locale=el;
                    },
                    (err)=>{

                    }
                );
            }
        }
    }
</script>
