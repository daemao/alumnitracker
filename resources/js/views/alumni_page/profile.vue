
<template>
    <div class="base" v-if="$root && $root.user && $root.user.data && $root.user.data.id">
        <div class="main">
            <div class="topper">
                <h1 class="name">{{user.first_name}} {{user.last_name}}</h1>
                <h2 class="name1" v-if="user.status_id==1">{{$t("roleAlumni.workingAt")}} {{user.current_company.company.name}}</h2>
                <h2 class="name1" v-if="user.status_id==2">{{$t("roleAlumni.studyingAt")}} {{user.current_university.university.name}}</h2>
            </div>
            <div class="bottom">
                <div class="left">
                    <div class="avatar">
                        <template v-if="user.avatar">
                            <img :src="'/storage/'+user.avatar.url" alt="there is an image" class="avatar" >
                        </template>
                        <template v-else>
                            <img src='/storage/noimage.png' class="avatar">
                        </template>
                        <input type="file" accept="image/png, image/jpeg" @change="sendFile" ref="upload_image_button" hidden />
                        <div class="container">
                            <div v-if="user.photos && user.photos.length>0" class="row"  >
                                <div class="col-4" v-for="(photo,i) in user.photos" v-if="i<3" style="padding:0px;margin:0px;">
                                    <img  :key="'photo_'+photo.id" :src="'/storage/'+photo.url" style="width: 100%"/>
                                </div>
                            </div>
                        </div>
                        <div class="upload_button" @click="$refs.upload_image_button.click()"
                            v-if="id==$root.user.data.id"
                        >{{$t("roleAlumni.uploadImage")}}</div>
                    </div>
                </div>
                <div class="right">
                    <div style="width:100%">
                        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                            <ul class="navbar-nav ">
                                <!--<li :class="{active:current_tab=='news'}" class="nav-item"><a href="" @click.prevent="current_tab='news'" class="nav-link">News</a></li>-->
                                <li :class="{active:current_tab=='education'}" class="nav-item"><a href="" @click.prevent="current_tab='education'"class="nav-link">{{$t("roleAlumni.education")}}</a></li>
                                <li :class="{active:current_tab=='work_experience'}" class="nav-item"><a href="" @click.prevent="current_tab='work_experience'"class="nav-link">{{$t("roleAlumni.workExperience")}}</a></li>
                                <li :class="{active:current_tab=='achievements'}" class="nav-item"><a href="" @click.prevent="current_tab='achievements'"class="nav-link">{{$t("roleAlumni.achievements")}}</a></li>
                                <li :class="{active:current_tab=='followers'}" class="nav-item"><a href="" @click.prevent="current_tab='followers'"class="nav-link">{{$t("roleAlumni.followers")}}  <badge class="badge badge-light"><span class="h6">{{user.followers?user.followers.length:0}}</span></badge></a></li>
                                <li :class="{active:current_tab=='followings'}" class="nav-item"><a href="" @click.prevent="current_tab='followings'"class="nav-link">{{$t("roleAlumni.followings")}}  <badge class="badge badge-light"><span class="h6"> {{user.followings?user.followings.length:0}}</span></badge></a></li>
                            </ul>
                        </nav>
                        <Achievements v-if="current_tab=='achievements'" :profile="user" v-on:update="getItem()"/>
                        <Education v-if="current_tab=='education'" :profile="user" v-on:update="getItem()"/>
                        <News v-if="current_tab=='news'" v-on:update="getItem()"/>
                        <WorkExperience v-if="current_tab=='work_experience'" :profile="user" v-on:update="getItem()"/>
                        <Followers v-if="current_tab=='followers'" :profile="user" v-on:update="getItem()"/>
                        <Followings v-if="current_tab=='followings'" :profile="user" v-on:update="getItem()"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Achievements from "./components/achievements.vue";
    import Education from "./components/education.vue";
    import Followers from "./components/followers.vue";
    import Followings from "./components/followings.vue";
    import WorkExperience from "./components/work_experience.vue";
    import {get,post} from "../../api";
    import Badge from "bootstrap-vue/es/components/badge/badge";
    export default {
        props:["id"],
        data(){
            return {
                user:"",
                loading:true,
                slide: 0,
                sliding: null,
                current_tab:'education'
            }
        },
        components:{
            Badge,
            Achievements,Education,WorkExperience,Followers,Followings
        },
        methods:{
            getItem(){
                let _this=this;
                get(_this,"/api/alumni/"+this.id,{},
                    (res)=>{
                        _this.user=res.data;
                    },
                    (err)=>{}
                );
            },
            sendFile(e){
                let _this=this;
                let formData = new FormData();
                formData.append('photo', e.target.files[0]);
                formData.append("id",_this.user.id);
                post(_this,"/api/update-user-photo",formData ,
                    (res)=>{
                        _this.user = res.data;
                    },
                    (err)=>{

                    })
            },
        },
        created(){
            this.getItem();
        },
        watch:{
            id: {
                handler: function(val, oldVal) {
                    if(val !== oldVal){
                        this.getItem();
                    }
                },
                deep: true
            }
        }
    }
</script>
<style scoped>
    .main{
        display: flex;
        flex-direction: column;
        justify-content: stretch;
        height: 100%;
        margin-right: 5vh;
        margin-left: 5vh;
    }
    .topper{
        height: 30vh;
        background-image: linear-gradient(#431C5D, #e7e3e5);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
    }
    .bottom{
        height: 70%;
        background-color: #e7e3e5;
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
        background-attachment: local;
    }
    .left{
        position: relative;
        top: -20vh;
        background: white;
        width: 25%;
        height: 100vh;
    }
    .right{
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 65%;
        margin-top: 3vh;
        margin_bottom: 3vh;
    }
    .avatar{
        display: flex;
        flex-direction: column;
        align-items: center;
        max-height: 70vh;
    }
/*Subjected to change */
    .upload_button{
        /*position: relative;*/
        /*bottom: -0px;*/
        text-align: center;
        font-weight:bold;
        font-size: 30px;
        font-family: cursive;
        background: red;
        width:70%;
        border-radius: 20px;
        z-index: 1000;
    }
    .upload_button:hover{
        border: 3px solid white;
        background: #d2afd3;
        font-color: white;
    }
    .name{
        font-size: 50px;
        text-align: center;
        font-family: monospace;
        color: white;
    }
    .name1{
        color: white;
        font-size: 30px;
        text-align: center;
        font-family: monospace;
    }

    .info{
        margin-top:100px;
        font-size: 20px;
        /*text-align: center;*/
        font-weight: bold;
    }
</style>

