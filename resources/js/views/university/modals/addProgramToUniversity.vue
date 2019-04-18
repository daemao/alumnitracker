<template>
    <modal :title="$t('university.add_program')" ref="modal">
        <template slot="body">
            <div class="form-group">
                <select class="form-control" v-model="department_id">
                    <option v-for="department in $common.data.departments" :value="department.id">{{department.name}}</option>
                </select>
            </div>
            <div class="form-group">
                <label class="label">{{$t("university.programs_available")}}</label>
                <div v-for="program in $common.data.programs">
                    <input type="checkbox" :value="program.id" v-model="selected_programs"/>
                    <label>{{program.name}}</label>
                </div>
            </div>
        </template>
        <template slot="footer">
            <button class="btn btn-secondary" @click="hide">{{$t('system.cancel')}}</button>
            <button class="btn btn-primary" @click="addDepartmentsToUniversity">{{$t('system.add')}}</button>
        </template>
    </modal>
</template>
<script>
    import {post} from "../../../api";
    export default {
        props:["university"],
        data(){
            return{
                selected_programs:[],
                department_id:""
            }
        },
        methods:{
            show(){
               this.$refs.modal.show();
            },
            hide(){
                this.$refs.modal.hide();
            },
            addDepartmentsToUniversity(){
                let _this=this;
                let form={
                    university_id:_this.university.id,
                    department_id:_this.department_id,
                    selected_programs:_this.selected_programs
                }
                post(_this,"/api/add-university-department",form,
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
