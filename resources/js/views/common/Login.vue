
<template>
    <div class="auth_page" v-on:keyup.enter="login">
        <div class="auth_wrap">
            <h1 class="auth_logo">Alumnitracker</h1>
            <label class="form-group" style="width: 100%">
                <input v-model="form.username" class="form-control" placeholder="Email" ref="emailInput" />
            </label>
            <label class="form-group" style="width: 100%">
                <input v-model="form.password" class="form-control" type="password" placeholder="password"/>
            </label>
            <label v-if="error" class="form-error-message">
                {{$t(error)}}
            </label>
            <button @click="login"  class="btn btn-primary btn-block" :class="{disabled:loading}">
                <div class="spinner-grow text-light spinner-grow-sm" v-if="loading">
                    <span class="sr-only"> </span>
                </div>
                <template >{{loading?$t("system.loading"):$t("system.login")}}</template>
            </button>
        </div>
    </div>
</template>

<script>
    import {post} from "../../api";
    export default{
        data(){
            return{
                form:{
                    username:"",
                    password:"",
                    client_id:2,
                    client_secret:"hVzhCm9E7gK3vyo0aLrDUgaD9slMmIzU5cx6W2g1",
                    grant_type:"password"
                },
                loading:false,
                error:""
            }
        },
        mounted(){
            this.$refs.emailInput.focus();
        },
        methods:{
            login() {
                let component = this;
                this.loading = true;
                post(
                    component,
                    "/oauth/token",
                    this.form,
                    function(response) {
                        console.log(response)
                        component.$auth.setToken(
                            response.data.access_token,
                            response.data.expires_in + Date.now()
                        );

                        component.loading = false;
                        component.error = "";

                        component.$common.getData();

                        component.$root.userInit(true);
                    },
                    function(res) {
                        component.select = false;
                        component.loading = false;
                        component.error = "system.incorrect_credentials";
                    }
                );
            }
        },

    }
</script>
<style scoped>
    .auth_page{
        position:absolute;
        top:0;
        left:0;
        width: 100vw;
        height: 100vh;
        flex-direction: column;
        display:flex;
        justify-content: center;
    }
    .auth_wrap{
        width: 320px;
        padding: 0 10px;
        margin-left: auto;
        margin-right: auto;
    }
    .auth_logo{
        text-align: center;
        color: #E200AD;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1em;
    }
</style>
