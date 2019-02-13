<template>
    <nav class="navbar navbar-dark bg-primary">
        <router-link class="navbar-brand" :to="{ name: 'home' }">Alumnitracker</router-link>
        <div class="headbar-left">
            <div style="margin-right:40px;">
                <span :class="{'headbar-muted':$i18n.locale==='en'}" @click="$i18n.locale='en'">En</span>
                <span :class="{'headbar-muted':$i18n.locale==='ru'}" @click="$i18n.locale='ru'">Ru</span>
            </div>
            <div class="headbar-exit" @click="logout"> </div>
        </div>

    </nav>
</template>
<script>
    export default {
        methods:{
            logout() {
                this.$auth.destroyToken();
                this.$router.push({name: "login"});
                this.$root.user = "";
            },
        }
    }
</script>
