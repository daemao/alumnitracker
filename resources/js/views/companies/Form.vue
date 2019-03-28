<template>
    <modal ref="modal" :title="$t('company.modals.create_header')">
        <template slot="body">
            <form>
                <div class="form-group row">
                    <label class="col-3 col-form-label">{{$t("company.name")}}</label>
                    <div class="col-9">
                        <input type="text"  class="form-control" v-model="form.name" >
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
            show(company){
                if(company){
                    this.form = company;
                }
                this.$refs.modal.show();
            },
            hide(){
                this.$refs.modal.hide();
            },
            sendForm(){
                let _this= this;
                post(_this,"/api/company/save",_this.form,
                    (res)=>{
                        _this.$emit("update");
                        _this.form = _this.newCompany();
                        _this.$refs.modal.hide();
                    },
                    (err)=>{
                        console.log(err);
                    }
                );
            },
            newCompany(){
                return {
                    name:""
                }
            }
        }
    }
</script>
