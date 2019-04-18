<template>
    <div>

        <AchievementForm ref="ach" v-on:update="$emit('update')"/>
        <div style="text-align:center;" class="h1 m-2">
            {{$t("roleAlumni.achievements")}}
            <span @click="$refs.ach.show(profile.id)" class="btn btn-primary btn-sm"
                v-if="profile.id== $root.user.data.id"
            >{{$t("system.create")}}</span>
        </div>
        <div v-for="info in profile.achievements" class="achievement-container">
            <div><span class="h5">{{$t("system.date")}}: </span>{{getDate(info.time)}}</div>
            <div><span class="h6">{{$t("system.time")}}: </span>{{getTime(info.time)}}</div>
            <div><span class="h5">{{$t("roleAlumni.description")}}:</span>{{info.description}}</div>
        </div>
    </div>
</template>
<script>
    import AchievementForm from "../../alumni/modals/Achievement.vue";
    import moment from "moment";
    export default {
        props:["profile"],
        components:{
            AchievementForm
        },
        methods:{
            getDate(time){
                return moment(time,"YYYY-MM-DD hh-mm-ss").format("MMMM Do YYYY");
            },
            getTime(time){
                return moment(time,"YYYY-MM-DD hh-mm-ss").format("hh:mm");
            }
        }
    }
</script>
<style scoped>
    .achievement-container{
        background: #9f79e6;
        border-radius: 20px ;
        padding:20px;
        margin-top:1vh;
        margin-bottom:1vh;
    }
</style>
