<template>
    <div v-if="user" class="row">
        <div class="col-2">
            <template v-if="user.avatar">
                <img :src="'/storage/'+user.avatar.url" alt="there is an image" class="avatar" >
            </template>
            <input type="file" accept="image/png, image/jpeg" @change="sendFile" ref="upload_image_button" hidden />
            <div class="btn btn-primary mt-0 btn-sm btn-block" @click="$refs.upload_image_button.click()"> upload image</div>
        </div>
        <div class="col-10">
            <div class="container">
                <div class="h4">{{user.first_name + " "+user.last_name}}</div>
                <div class="row">
                    <div class="col-6">Email</div>
                    <div class="col-6">{{user.email}}</div>
                </div>
                <div class="row">
                    <div class="col-6">Phone</div>
                    <div class="col-6">TODO</div>
                </div>
                <div class="h5">Social networks</div>
                <div class="btn btn-sm btn-warning" @click="edit_socials=true">edit</div>
                <div class="row">
                    <div class="col-6">Facebook</div>
                    <div class="col-6">
                        <a v-if="!goToGithubCheck(user.socials_fb) && !edit_socials" :href="user.socials_fb">
                            {{user.socials_fb}}
                        </a>
                        <input class="form-control" v-else-if="edit_socials" v-model="user.socials_fb"/>
                        <div v-else>not given</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6" >Github</div>
                    <div class="col-6">
                        <a v-if="!goToGithubCheck(user.socials_github) && !edit_socials" :href="user.socials_github">
                            {{user.socials_github}}
                        </a>
                        <input v-else-if="edit_socials" v-model="user.socials_github"/>
                        <div v-else>not given</div>
                    </div>
                </div>
                <div class="row" >
                    <div class="col-6">Vkontakte</div>
                    <div class="col-6">
                        <a v-if="!goToVkCheck(user.socials_vk) && !edit_socials" :href="user.socials_vk">
                            {{user.socials_vk}}
                        </a>
                        <input v-else-if="edit_socials"v-model="user.socials_vk"/>
                        <div v-else> not given</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">Twitter</div>
                    <div class="col-6">
                        <a v-if="!goToTwitterCheck(user.socials_twitter) && edit_socials" :href="user.socials_socials_twitter">
                            {{user.socials_twitter}}
                        </a>
                        <input v-else-if="edit_socials"v-model="user.socials_twitter"/>
                        <div v-else> not given</div>
                    </div>
                </div>
                <div class="row" v-if=" edit_socials">
                   <button class="btn btn-block btn-primary" @click="save"> Save changes</button>
                </div>
            </div>
            <div class="container mt-5">
                <div class="h4 text-center">NU graduation information</div>
                <div class="card container mt-4" v-for = "info in user.alumni_info" v-if="info.university_id == 1 ">
                    <div class="card-title h5 text-center mt-2">{{info.program.name }} </div>
                    <div class="row">
                        <div class="col-6"> Graduation year</div>
                        <div class="col-6"><span class=" float-right">{{info.graduate_year}}</span></div>
                    </div>
                    <div class="row">
                        <div class="col-6">University ID</div>
                        <div class="col-6 "><span class="float-right">{{info.id_in_university}}</span></div>
                    </div>
                    <div class="row">
                        <div class="col-6">Department</div>
                        <div class="col-6 "><span class="float-right">{{info.department.name}}</span></div>
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
