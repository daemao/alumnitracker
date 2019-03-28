<template>
    <div>
        Achievements
        <AchievementForm ref="ach"/>
        <div @click="$refs.ach.show(profile.id)">add new achievement</div>
        <div v-for="info in profile.achievements">
            {{info.time}}-{{info.description}}
        </div>
    </div>
</template>
<script>
    import AchievementForm from "../../alumni/modals/Achievement.vue"
    export default {
        props:["profile"],
        components:{
            AchievementForm
        }
    }
</script>
