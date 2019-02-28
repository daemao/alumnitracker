<template>
    <modal ref="modal" :title="$t('administrators.modals.create_header')">
        <template slot="body">
            <form>
                <div class="form-group row">
                    <label class="col-3 col-form-label">{{$t("alumni.first_name")}}</label>
                    <div class="col-9">
                        <input type="text"  class="form-control" v-model="form.first_name" >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-3 col-form-label">{{$t("alumni.last_name")}}</label>
                    <div class="col-9">
                        <input type="text"  class="form-control" v-model="form.last_name" >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-3 col-form-label">{{$t("alumni.email")}}</label>
                    <div class="col-9">
                        <input type="email"  class="form-control " v-model="form.email" >
                    </div>
                </div>
            </form>
        </template>
        <template slot="footer">
            <button class="btn btn-secondary float-left "> {{$t("system.cancel")}}</button>
            <button class="btn btn-primary float-right " @click="sendForm"> {{$t("system.create")}}</button>
        </template>
    </modal>
</template>
<script>
    import {post} from "../../api";
    export default {
        data(){
            return {
                form:{}
            }
        },
        methods:{
            show(user){
                if(user){
                    this.form = user;
                }
                this.$refs.modal.show();
            },
            hide(){
                this.$refs.modal.hide();
            },
            sendForm(){
                let _this= this;
                _this.form.role_id = 1;
                post(_this,"/api/user/save",_this.form,
                    (res)=>{
                        _this.$emit("update");
                        _this.form = _this.newAdmin();
                        _this.$refs.modal.hide();
                    },
                    (err)=>{
                        console.log(err);
                    }
                );
            },
            newAdmin(){
                return {
                    first_name:"",
                    last_name:"",
                    email:"",
                    role_id:1
                }
            }
        }
    }
</script>
