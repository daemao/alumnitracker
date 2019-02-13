<template>
    <div>
        Login page
        <input v-model="form.username"/>
        <input v-model="form.password"/>
        <button @click="login"> {{$t("system.login")}}</button>
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
                    client_secret:"1SzvmwTYI1vuAh9ikEX2uPcJo6knI4dE9ZQCi74x",
                    grant_type:"password"
                },
                loading:false,
            }
        },
        methods:{
            login() {
                let component = this;
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
                    function() {
                        component.select = false;
                        component.loading = false;
                        component.error = {
                            message: "Имя пользователя и пароль не совпадают."
                        };
                    }
                );
            }
        },

    }
</script>
