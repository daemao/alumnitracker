<template>
    <div>
        <div style="text-align:center;" class="h1 m-2">
            {{$t("roleAlumni.followers")}}
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>{{$t("alumni.first_name")}}</th>
                    <th>{{$t("alumni.last_name")}}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="follower  in followers" @click="$router.push('/profile/'+follower.id)">
                    <td>{{follower.first_name}}</td>
                    <td>{{follower.last_name}}</td>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>
<script>
    export default {
        props:["profile"],
        data(){
            return{
                followers:this.profile.followers
            }
        },
        watch:{
            profile: {
                handler: function(val, oldVal) {
                    if(val !== oldVal){
                        this.followers = this.profile.followers
                    }
                },
                deep: true
            }
        }
    }
</script>
<style scoped>

</style>
