<template>
    <modal ref="modal" title="New work experience">
        <template slot="body">
            <div class="form">
                <div class="form-group row">
                    <label class="col-4">Company</label>
                    <select class="col-8 form-control" v-model="form.company_id" >
                        <option :value="company.id" v-for="company in $common.data.companies" >{{company.name}}</option>
                        <option value="other">other</option>
                    </select>
                </div>
                <template v-if="form.company_id =='other'">
                    <div class="form-group row" >
                        <label class="col-4">Company name:</label>
                        <input class="col-8 form-control" v-model="form.new_company"/>
                    </div>
                </template>
                <div class="form-group row" >
                    <label class="col-4">Position:</label>
                    <input class="col-8 form-control" v-model="form.position"/>
                </div>
            </div>
        </template>
        <template slot="footer">
            <div class="btn btn-secondary" @click = "hide">{{$t('system.cancel')}}</div>
            <div class="btn btn-primary float-right" @click="createWorkExperience" >add work experience</div>
        </template>
    </modal>
</template>
<script>
    import {post} from "../../../api";
    export default {
        data(){
            return{
                form:{
                    user_id:'',
                    company_id:'',
                    new_company:'',
                    position:''
                }
            }
        },
        methods:{
            show(user_id){
                this.form.user_id = user_id;
                this.$refs.modal.show();
            },
            hide(){
                this.$refs.modal.hide();
            },
            createWorkExperience(){
                let _this=this;
                post(_this,"/api/alumni/save-work-experience",this.form,
                    (res)=>{
                        _this.$emit("update");
                        _this.hide();
                    },
                    (err)=>{}
                );
            }
        }
    }
</script>
