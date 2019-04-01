<template>
    <div>
        <WEForm ref="new_exp"/>
        <div style="text-align:center;" class="h1 m-2">
            Work experience
            <span @click="$refs.new_exp.show(profile.id)" class="btn btn-primary btn-sm">add new work experience</span>
        </div>
        <div v-for="info in profile.work_experience" class="we-container">
            <div><span class="h5">Company:</span>{{info.company.name}}</div>
            <div><span class="h5">Position:</span>{{info.position}}</div>
        </div>
    </div>
</template>
<script>
    import WEForm from "../../alumni/modals/Work_experience_modal.vue"
    export default {
        props:["profile"],
        components:{
            WEForm
        }
    }
</script>
<style scoped>
    .we-container{
        background: #9f79e6;
        border-radius: 20px ;
        padding:20px;
        margin-top:1vh;
        margin-bottom:1vh;

    }
</style>
