<template>
    <modal ref="modal" title="New graduate information">
        <template slot="body">
            <div class="form">
                <div class="form-group row">
                    <label class="col-4">University id</label>
                    <input class="col-8 form-control" v-model="id_in_university" />
                </div>
                <div class="form-group row">
                    <label class="col-4">Graduation year</label>
                    <select  v-model="graduate_year" class="col-8 form-control select">
                        <option value="" v-if="graduate_year =='' ">select graduation year</option>
                        <option v-for="year in $root.getAvailableGraduationYears()">{{year}}</option>
                    </select>
                </div>
                <div class="form-group row">
                    <label class="col-4" >Program</label>
                    <select  v-model="program_id" class="col-8 form-control select">
                        <option value="" v-if="program_id =='' ">select program</option>
                        <option :value="program.id "v-for="program in $common.data.programs">{{program.name}}</option>
                    </select>
                </div>
                <div class="form-group row" v-if="program_id">
                    <label class="col-4">Department</label>
                    <select  v-model="department_id" class="col-8 form-control select">
                        <option value="" v-if="department_id ==''">select department</option>
                        <option :value="department.id"
                                v-for="department in $common.data.nu_departments.filter(e=>e.pivot.program_id===program_id)">{{department.name}}</option>
                    </select>
                </div>
                <div class="form-group row">
                    <label class="col-4">Culminate gpa</label>
                    <input class="col-8 form-control" type="number" v-model="cumulative_gpa" step="0.01"/>
                </div>
            </div>
        </template>
        <template slot="footer">
            <div class="btn btn-secondary" @click = "hide">{{$t('system.cancel')}}</div>
            <div class="btn btn-primary float-right" :class="{'disabled':!department_id || !cumulative_gpa || cumulative_gpa>4 || cumulative_gpa<0}"@click="createGraduationInfo" >add alumni information</div>
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
                cumulative_gpa:"",
                program_id:"",
                id_in_university:"",
                graduate_year:""
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
                    cumulative_gpa:this.cumulative_gpa,
                    program_id:this.program_id,
                    university_id:1,
                    id_in_university:this.id_in_university,
                    graduate_year:this.graduate_year
                }
                post(_this,"/api/alumni/save-alumni-info",form,
                    (res)=>{},
                    (err)=>{}
                );
            }
        }
    }
</script>
