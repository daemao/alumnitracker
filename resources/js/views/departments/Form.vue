<template>
    <modal ref="modal" title="Add new departmnet">
        <template slot="body">
            <form>
                <div class="form-group row">
                    <label class="col-4"> English name</label>
                    <input class="form-control col-8" v-model="form.en"/>
                </div>
                <div class="form-group row" v-if="!showTranslation">
                    <div class="btn btn-success btn-block" @click="showTranslation=true"> Show russian translation </div>
                </div>
                <template v-if="showTranslation">
                    <div class="form-group row">
                        <label class="col-4"> Russian name</label>
                        <input class="form-control col-8" v-model="form.ru"/>
                    </div>
                </template>
            </form>
        </template>
        <template slot="footer">
            <div class="btn btn-secondary"> cancel</div>
            <div class="btn btn-primary" @click="sendForm"> create</div>

        </template>
    </modal>
</template>
<script>
    import {post} from "../../api";
    export default {
        data(){
            return {
                showTranslation:false,
                form:{
                    en:"",
                    ru:""
                }
            }
        },
        methods:{
            show(){
                this.$refs.modal.show();
            },
            hide(){
                this.$refs.modal.hide();
            },
            sendForm(){
                let _this=this;
                post(_this,"/api/department/save",_this.form,
                    (res)=>{
                        console.log(res);
                    },
                    (err)=>{
                        console.log(err);
                    })
            }
        }
    }
</script>
