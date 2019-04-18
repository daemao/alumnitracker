<style scoped>
    .allowed{
        color:#ffffff;
    }
</style>
<template>
    <nav class="navbar fixed-top navbar-dark bg-primary ">
            <router-link class="navbar-brand" :to="{ name: 'dashboard' }" v-if="$root.user.data.role_id==1">Alumnitracker</router-link>
            <router-link class="navbar-brand" :to="{ path: '/profile/'+$root.user.data.id }" v-if="$root.user.data.role_id==2">Alumnitracker</router-link>

            <div class="headbar-left">
                <div style="margin-right:40px;" class="nav-item">
                    <span :class="{'disabled':$i18n.locale==='en','muted':$i18n.locale==='en','allowed':$i18n.locale!=='en'}" @click="changeLocale('en')">English</span>
                    <span :class="{'disabled':$i18n.locale==='ru','muted':$i18n.locale==='ru','allowed':$i18n.locale!=='ru'}" @click="changeLocale('ru')" class="pl-4">Русский</span>
                    <span  @click="logout"  class="mr-3 ml-3 allowed">{{$t("system.logout")}} </span>
                </div>
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
