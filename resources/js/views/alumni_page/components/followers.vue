<template>
    <div>
        <div style="text-align:center;" class="h1 m-2">
            Followers
        </div>

    </div>
</template>
<script>
    import {get} from "../../../api";
    export default {
        props:["profile"],
        data(){
            return{
                followers:[]
            }
        },
        methods:{
            getList(){
                let _this=this;
                get(_this,"/api/alumni/"+_this.profile.id+"/followers",{},()=>{},()=>{});
            }
        },
        mounted(){
            this.getList();
        }
    }
</script>
<style scoped>

</style>
