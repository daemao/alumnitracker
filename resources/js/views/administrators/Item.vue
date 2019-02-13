<template>
    <div v-if="user" class="wrapper">
        <div class="profile_image">
            <template v-if="user.avatar">
                <img :src="'/storage/'+user.avatar.url" alt="there is an image" class="avatar" >
            </template>
            <input type="file" accept="image/png, image/jpeg" @change="sendFile" ref="upload_image_button" hidden />
            <div class="button button-primary" @click="$refs.upload_image_button.click()"> upload image</div>
        </div>
        <div class="general_info">
            <div class="general_info-row">
                <div class="general_info-key"> First name</div>
                <div class="general_info-value">{{user.first_name}}</div>
            </div>
            <div class="general_info-row">
                <div class="general_info-key">Last name</div>
                <div class="general_info-value">{{user.last_name}}</div>
            </div>
            <div class="general_info-row">
                <div class="general_info-key">Email</div>
                <div class="general_info-value">{{user.email}}</div>
            </div>
            <div class="general_info-row">
                <div class="general_info-key">Role</div>
                <div class="general_info-value">{{user.role.name}}</div>
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
            return{
                user:'',
                loading:true
            }
        },
        methods:{
            getItem(){
                let _this=this;
                this.loading=true;
                get(_this,"/api/user/"+_this.id,{},
                    (res)=>{
                        _this.user=res.data;
                    },
                    (err)=>{})
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
