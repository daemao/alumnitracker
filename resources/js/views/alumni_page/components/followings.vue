<template>
    <div>
        <SearchAlumniModal ref="search" :user_id="profile.id" v-on:update="$emit('update')"/>
        <div style="text-align:center;" class="h1 m-2">
            {{$t("roleAlumni.followings")}}
            <div class="btn btn-primary btn-sm" @click="$refs.search.show()" v-if="$root.user.data.id==profile.id">Search</div>
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
                    <tr v-for="following  in followings" @click="$router.push('/profile/'+following.id)">
                        <td >{{following.first_name}}</td>
                        <td>{{following.last_name}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    import SearchAlumniModal from "../modals/search_alumni_modal.vue";
    export default {
        props:["profile"],
        data(){
            return{
                followings:this.profile.followings
            }
        },
        components:{
            SearchAlumniModal
        },
        watch:{
            profile: {
                handler: function(val, oldVal) {
                    if(val !== oldVal){
                        this.followings = this.profile.followings
                    }
                },
                deep: true
            }
        }
    }
</script>
<style scoped>

</style>
