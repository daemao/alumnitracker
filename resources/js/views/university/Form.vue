<template>
    <modal title="Create University" ref="modal">
        <template slot="body">
            <form class="contrainer">
                <div class="form-group row">
                    <label class="label col-4">{{$t("system.english_name")}}</label>
                    <input type="text" class="col-8 form-control" v-model="form.names.en"/>
                </div>
                <div class="form-group row">
                    <template v-if="showRussianName">
                        <label class="label col-4">{{$t("system.russian_name")}}</label>
                        <input type="text" class="col-7 form-control" v-model="form.names.ru"/>
                        <div class="col-1">
                        <button class="btn btn-sm btn-danger" @click.prevent="showRussianName=false">{{$tc("system.remove")}}</button>
                        </div>
                    </template>
                    <template v-else>
                        <button class="btn btn-primary block" @click.prevent="showRussianName=true"> {{$t("system.add_translation")}}</button>
                    </template>
                </div>
                <div class="form-group row">
                    <label class="form-check-label col-3"> {{$t("system.country")}}</label>
                    <select class="form-control col-9" v-model="form.country_id">
                        <option v-for="country in $common.data.countries" :value="country.id">
                            {{country.name}}
                        </option>
                    </select>
                </div>
            </form>
            <div class="container">
                <template v-if="!showDepartments">
                    <button class="btn btn-primary btn-lg block" @click="showDepartments=true">{{$tc("system.add_department")}}</button>
                </template>
                <template v-else>
                    <div class="row" v-for="department in form.departments">
                        {{department.name}}
                    </div>
                    <div class="row">
                        <select class="custom-select" v-model="departmentToAdd" >
                            <option v-for="department in $common.data.departments" :value="department">{{department.name}}</option>
                        </select>
                        <div class="btn btn-success" @click="pushDepartmentToUniversity">{{$t("system.add")}}</div>
                    </div>
                </template>
            </div>
        </template>
        <template slot="footer">
            <button class="btn btn-secondary">{{$tc("system.cancel")}}</button>
            <button class="btn btn-primary" @click.prevent="sendForm">{{$t("system.create")}} </button>
        </template>
    </modal>
</template>
<script>
    import {post} from "../../api";
    export default{
        data(){
            return {
                showRussianName:false,
                showDepartments:false,
                departmentToAdd:{},
                form:{
                    names:{
                        en:"",
                        ru:""
                    },
                    country_id:"",
                    departments:[]
                },

            }
        },
        methods:{
            show(university=null){
                if(university)this.form=university;
                this.$refs.modal.show();
            },
            hide(){
              this.$refs.modal.hide();
            },
            pushDepartmentToUniversity(){
                this.form.departments.push(this.departmentToAdd);
                this.departmentToAdd={};
            },
            sendForm(){
                let _this=this;
                post(_this,"/api/university/save",_this.form,
                    (res)=>{
                        _this.$emit("updated");
                        _this.hide();
                    },
                    (err)=>{})
            }
        }
    }
</script>
