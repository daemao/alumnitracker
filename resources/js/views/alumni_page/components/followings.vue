<template>
    <div>
        <div style="text-align:center;" class="h1 m-2">
            Followings
        </div>

    </div>
</template>
<script>
    import {get} from "../../../api";
    export default {
        props:["profile"],
        data(){
            return{
                followings:[]
            }
        },
        methods:{
            getList(){
                let _this=this;
                get(_this,"/api/alumni/"+_this.profile.id+"/followings",{},()=>{},()=>{});
            }
        },
        mounted(){
            this.getList();
        }
    }
</script>
<style scoped>

</style>
