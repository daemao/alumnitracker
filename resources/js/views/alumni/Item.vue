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
                loading:true
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
            }
        },
        created(){
            this.getItem();
        }
    }
</script>
