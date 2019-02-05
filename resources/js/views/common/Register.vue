<template>
    <div>
        Registration page
        <input v-model="email"/>
        <input v-model="password"/>
        Email: {{email}}
        Password:{{password}}
    </div>
</template>
<script>
    export default{
        data(){
            return{
                email:"",
                password:""
            }
        }
    }
</script>
