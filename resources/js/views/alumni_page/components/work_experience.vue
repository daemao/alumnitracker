<template>
    <div>
        WE
        <WEForm ref="new_exp"/>
        <div @click="$refs.new_exp.show(profile.id)">add new work experience</div>
        <div v-for="info in profile.work_experience">
            Company:{{info.company.name}}
            Position:{{info.position}}
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
