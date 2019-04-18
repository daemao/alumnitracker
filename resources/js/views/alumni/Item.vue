<template>
    <div v-if="user" class="row">
        <div class="col-2">
            <template v-if="user.avatar">
                <img :src="'/storage/'+user.avatar.url" alt="there is an image" class="avatar" >
            </template>
            <input type="file" accept="image/png, image/jpeg" @change="sendFile" ref="upload_image_button" hidden />
            <div class="btn btn-primary mt-0 btn-sm btn-block" @click="$refs.upload_image_button.click()"> {{$t("system.upload_image")}}</div>
        </div>
        <div class="col-10">
            <div class="container">
                <div class="h4">{{user.first_name + " "+user.last_name}}</div>
                <div class="row">
                    <div class="col-6">{{$t("alumni.email")}}</div>
                    <div class="col-6">{{user.email}}</div>
                    <template v-if="user.status_id ==1">
                        <div class="col-6">{{$t("roleAlumni.workingAt")}}</div><div class="col-6"> {{user.current_company.company.name}}</div>

                    </template>
                    <template v-if="user.status_id ==2">
                        <div class="col-6">{{$t("roleAlumni.studyingAt")}}</div><div class="col-6"> {{user.current_university.university.name}}</div>
                    </template>
                </div>

                <div class="h4 mt-3 mb-2">
                    {{$t("alumni.socials")}}
                    <span class="btn btn-sm btn-primary float-right" style="padding: 0.05rem 0.50rem;" @click="edit_socials=true" v-if="!edit_socials">{{$t("alumni.edit_socials")}}</span>
                </div>
                <div class="row">
                    <div class="col-6">Facebook</div>
                    <div class="col-6">
                        <a v-if="!goToGithubCheck(user.socials_fb) && !edit_socials" :href="user.socials_fb">
                            {{user.socials_fb}}
                        </a>
                        <input class="form-control" v-else-if="edit_socials" v-model="user.socials_fb"/>
                        <div v-else>{{$t("system.not_given")}}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6" >Github</div>
                    <div class="col-6">
                        <a v-if="!goToGithubCheck(user.socials_github) && !edit_socials" :href="user.socials_github">
                            {{user.socials_github}}
                        </a>
                        <input v-else-if="edit_socials" class="form-control" v-model="user.socials_github"/>
                        <div v-else>{{$t("system.not_given")}}</div>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-6">Vkontakte</div>
                    <div class="col-6">
                        <a v-if="!goToVkCheck(user.socials_vk) && !edit_socials" :href="user.socials_vk">
                            {{user.socials_vk}}
                        </a>
                        <input class="form-control" v-else-if="edit_socials"v-model="user.socials_vk"/>
                        <div v-else> {{$t("system.not_given")}}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">Twitter</div>
                    <div class="col-6">
                        <a v-if="!goToTwitterCheck(user.socials_twitter) && edit_socials" :href="user.socials_socials_twitter">
                            {{user.socials_twitter}}
                        </a>
                        <input v-else-if="edit_socials" class="form-control" v-model="user.socials_twitter"/>
                        <div v-else> {{$t("system.not_given")}}</div>
                    </div>
                </div>
                <div class="row" v-if=" edit_socials">
                   <button class="btn btn-block btn-primary" @click="save"> {{$t("system.update")}}</button>
                </div>
            </div>
            <div class="container mt-5">
                <div class="h4 text-center">{{$t("roleAlumni.achievements")}}</div>
                <div  class="card container mt-2" v-for="info in user.achievements">
                    <div class="row">
                        <div class="col-6">{{$t("system.date")}}: </div>
                        <div class="col-6">{{getDate(info.time)}} </div>
                    </div>
                    <div class="row">
                        <div class="col-6">{{$t("system.time")}}: </div>
                        <div class="col-6">{{getTime(info.time)}} </div>
                    </div>
                    <div class="h5 text-center">{{$t("roleAlumni.description")}}</div>
                    <p class="h6">
                        {{info.description}}
                    </p>
                </div>
            </div>
            <div class="container mt-5">
                <div class="h4 text-center">{{$t("roleAlumni.education")}}</div>
                <div class="card container mt-2" v-for = "info in user.alumni_info" >
                    <div class="card-title h5 text-center mt-2">
                        <template>{{$tc("university.programs."+info.program.name)}}</template>
                    </div>
                    <div class="row">
                        <div class="col-6"> {{$t("alumni.graduation_year")}}</div>
                        <div class="col-6"><span class=" float-right">{{info.graduate_year}}</span></div>
                    </div>
                    <div class="row">
                        <div class="col-6">{{$t("alumni.department")}}</div>
                        <div class="col-6 "><span class="float-right">{{info.department.name}}</span></div>
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <div class="h4 text-center">{{$t("roleAlumni.workExperience")}}</div>
                <div  class="card container mt-2" v-for="info in user.work_experience">
                    <div class="row">
                        <div class="col-6">{{$t("system.Company")}}: </div>
                        <div class="col-6">{{info.company.name}} </div>
                    </div>
                    <div class="row">
                        <div class="col-6">{{$t("roleAlumni.position")}}: </div>
                        <div class="col-6">{{info.position}} </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        Error
    </div>
</template>
<script>
    import {get,post} from "../../api";
    import moment from "moment";
    export default {
        props:["id"],
        data(){
            return {
                user:"",
                loading:true,
                edit_socials:false
            }
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
            getDate(time){
                return moment(time,"YYYY-MM-DD hh-mm-ss").format("MMMM Do YYYY");
            },
            getTime(time){
                return moment(time,"YYYY-MM-DD hh-mm-ss").format("hh:mm");
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
            save(){
                let _this= this;
                post(_this,"/api/user/save",_this.user,
                    (res)=>{
                        _this.getItem();
                        _this.edit_socials=false;
                    },
                    (err)=>{
                        console.log(err);
                    }
                );
            },
            goToFbCheck(value){
                if(!value) return true;
                let regexp = new RegExp('(?:(?:http|https):\\/\\/)?(?:www.)?(facebook.com|fb.com)\\/(?:(?:\\w)*#!\\/)?(?:pages\\/)?(?:[?\\w\\-]*\\/)?(?:profile.php\\?id=(?=\\d.*))?([\\w\\-]*)?\n',"i");
                if(value.match(regexp)){
                    return false;
                }
                return true;
            },
            goToVkCheck(value) {
                if(!value) return true;
                let regexp = new RegExp("^(m.|(www.)|(http:\/\/)|()|(https:\/\/)|(http:\/\/))((vk.com)|(vkontakte.ru))\/([a-z|A-Z|0-9_]+|profile.php\?id\=[0-9]+)$","i");
                if(value.match(regexp)){
                    return false;
                }
                else return true;
            },
            goToGithubCheck(value) {
                if(!value) return true;
                let regexp = new RegExp("^(www.|http:\/\/|()|https:\/\/|http:\/\/)(github.com)\/[a-z|A-Z|0-9_]+$","i");
                if(value.match(regexp)){
                    return false;
                }
                else return true;
            },
            goToTwitterCheck(value) {
                if(!value) return true;
                let regexp = new RegExp("^/http(?:s)?:\\/\\/(?:www\\.)?twitter\\.com\\/([a-zA-Z0-9_]+)(/|)$","i");
                if(value.match(regexp)){
                    return false;
                }
                else return true;
            },
        },
        created(){
            this.getItem();
        }
    }
</script>
