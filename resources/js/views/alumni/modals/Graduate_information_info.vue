<template>
    <modal ref="modal" :title="$tc('alumni.new_graduation_info')">
        <template slot="body">
            <div class="form">
                <div class="form-group row" v-if="$root.user.isAlumni">
                    <label class="col-4">{{$t("system.university")}}</label>
                    <select class="col-8 form-control" v-model="university_id" >
                        <option :value="university.id" v-for="university in $common.data.universities" >{{university.name}}</option>
                        <option value="other">{{$tc("system.other")}}</option>
                    </select>
                </div>
                <template v-if="university_id =='other'">
                    <div class="form-group row" >
                        <label class="col-4">{{$t("system.university.name")}}</label>
                        <input class="col-8 form-control" v-model="new_university.name"/>
                    </div>
                    <div class="form-group row">
                        <label class="col-4">{{$t("system.country")}}</label>
                        <select class="col-8 form-control" v-model="new_university.country_id">
                            <option :value="country.id " v-for="country in $common.data.countries">{{country.name}}</option>
                            <option value="other">{{$tc("system.other")}}</option>
                        </select>
                    </div>
                    <div class="form-group row" v-if="university_id =='other' && new_university.country_id =='other'" >
                        <label class="col-4">{{$t("system.country_name")}}</label>
                        <input class="col-8 form-control" v-model="new_country.name"/>
                    </div>
                </template>
                <div class="form-group row">
                    <label class="col-4">{{$tc("alumni.graduation_year")}}</label>
                    <select  v-model="graduate_year" class="col-8 form-control select">
                        <option value="" v-if="graduate_year =='' ">{{$tc("alumni.select_graduation_year")}}</option>
                        <option v-for="year in $root.getAvailableGraduationYears()">{{year}}</option>
                    </select>
                </div>
                <div class="form-group row">
                    <label class="col-4" >{{$tc("alumni.program")}}</label>
                    <select  v-model="program_id" class="col-8 form-control select">
                        <option value="" v-if="program_id =='' ">{{$t("system.select")}}</option>
                        <option :value="program.id "v-for="program in $common.data.programs">{{program.name}}</option>
                    </select>
                </div>
                <div class="form-group row" v-if="program_id">
                    <label class="col-4">{{$t("alumni.department")}}</label>
                    <select  v-model="department_id" class="col-8 form-control select">
                        <option value="" v-if="department_id ==''">{{$t("system.select")}}</option>
                        <option :value="department.id"
                                v-for="department in $common.data.departments">{{department.name}}</option>
                        <option value="other">other</option>
                    </select>
                </div>
                <div class="form-group row" v-if="department_id == 'other'">
                    <label class="col-4">{{$t("alumni.department_name")}}</label>
                    <input class="col-8 form-control" v-model="new_department"/>
                </div>
            </div>
        </template>
        <template slot="footer">
            <div class="btn btn-secondary" @click = "hide">{{$t('system.cancel')}}</div>
            <div class="btn btn-primary float-right" :class="{'disabled':!department_id }"@click="createGraduationInfo" >{{$t("system.create")}}</div>
        </template>
    </modal>
</template>
<script>
    import {post} from "../../../api";
    export default {
        data(){
            return{
                user_id:"",
                department_id:"",
                program_id:"",
                graduate_year:"",
                university_id:"",
                new_university:{
                    name:"",
                    country_id:""
                },
                new_country:{
                    name:''
                },
                new_department:''
            }
        },
        methods:{
            show(user_id){
                this.user_id = user_id;
                this.$refs.modal.show();
            },
            hide(){
                this.$refs.modal.hide();
            },
            createGraduationInfo(){
                let _this=this;
                let form ={
                    user_id:this.user_id,
                    department_id:this.department_id,
                    program_id:this.program_id,
                    university_id:this.university_id?this.university_id:1,
                    graduate_year:this.graduate_year,
                    new_university:this.new_university,
                    new_country:this.new_country,
                    new_department:this.new_department
                }
                post(_this,"/api/alumni/save-alumni-info",form,
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
