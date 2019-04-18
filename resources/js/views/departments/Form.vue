<template>
    <modal ref="modal" :title="$tc('university.department.add_department_to_system')">
        <template slot="body">
            <div>
                <div class="form-group row">
                    <label class="col-4"> {{$t("system.english_name")}}</label>
                    <input class="form-control col-8" v-model="form.en"/>
                </div>
                <div class="form-group row" v-if="!showTranslation">
                    <div class="btn btn-success btn-block" @click="showTranslation=true"> {{$t("system.show_russian_tr")}} </div>
                </div>
                <template v-if="showTranslation">
                    <div class="form-group row">
                        <label class="col-4"> {{$t("system.russian_name")}}</label>
                        <input class="form-control col-8" v-model="form.ru"/>
                    </div>
                </template>
            </div>
        </template>
        <template slot="footer">
            <div class="btn btn-secondary" @click="hide()"> {{$t("system.cancel")}}</div>
            <div class="btn btn-primary" @click="sendForm"> {{form.id? $t('system.update'): $t('system.create')}}</div>
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
                    id:"",
                    en:"",
                    ru:""
                }
            }
        },
        methods:{
            show(item){
                if(item){
                    this.form.id=item.id;
                    if(item.translations && item.translations.length!=0){
                        for(let i = 0; i<item.translations.length;i++){
                            if(item.translations[i].locale =="ru") this.form.ru = item.translations[i].name;
                            if(item.translations[i].locale =="en") this.form.en = item.translations[i].name;
                        }
                    }
                }
                this.$refs.modal.show();
            },
            hide(){
                this.$refs.modal.hide();
            },
            sendForm(){
                let _this=this;
                post(_this,"/api/department/save",_this.form,
                    (res)=>{
                        _this.$emit("update");
                        _this.$refs.modal.hide();
                    },
                    (err)=>{
                        console.log(err);
                    })
            }
        }
    }
</script>
