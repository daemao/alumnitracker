<template>
    <div>
        <GraduateinfoForm ref="new_education" v-on:update="$emit('update')"/>
        <div style="text-align:center;" class="h1 m-2">
            {{$t("roleAlumni.education")}}
            <span @click="$refs.new_education.show(profile.id)" class="btn btn-primary btn-sm"
                v-if="$root.user.data.id==profile.id"
            >{{$t("system.create")}}</span>

        </div>
        <div v-for="info in profile.alumni_info" class="achievement">
            <h3>{{info.university.name}}<span class="badge badge-secondary float-right">{{info.program.name}}</span></h3>
            <div><span class="h5">{{$t("roleAlumni.education")}}:</span>{{info.department.name}}</div>
            <div><span class="h5">{{$t("university.department.name")}}:</span>{{info.university.country.name}}</div>
            <div><span class="h5">{{$t("alumni.graduation_year")}}:</span>{{info.graduate_year?info.graduate_year:"not provided"}}</div>
        </div>
    </div>
</template>
<script>
    import GraduateinfoForm from "../../alumni/modals/Graduate_information_info.vue"
    export default {
        props:["profile"],
        components:{
            GraduateinfoForm
        }
    }
</script>
<style scoped>
    .achievement{
        background: #9f79e6;
        border-radius: 20px ;
        padding:20px;
        margin-top:1vh;
        margin-bottom:1vh;

    }
</style>
