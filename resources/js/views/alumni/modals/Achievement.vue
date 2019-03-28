<template>
    <modal ref="modal" title="New achievement">
        <template slot="body">
            <div class="form">
                <div class="form-group " >
                    <label class="label">Achievement description</label>
                    <textarea class=" form-control" v-model="form.description"/>
                </div>
            </div>
        </template>
        <template slot="footer">
            <div class="btn btn-secondary" @click = "hide">{{$t('system.cancel')}}</div>
            <div class="btn btn-primary float-right" @click="createWorkExperience" >create achievement</div>
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
                    description:''
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
                post(_this,"/api/alumni/save-achievement",this.form,
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
