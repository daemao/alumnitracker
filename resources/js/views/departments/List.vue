<template>
    <div>
        <modal :title="$tc('university.department.remove_modal_title')" ref="removeModal">
            <template slot="body">
                <div>
                    {{$t("system.remove")}} {{toremove.name}}?
                </div>
            </template>
            <template slot="footer">
                    <button class="btn btn-secondary" @click= "toremove='';$refs.removeModal.hide()">
                        {{$t("system.cancel")}}
                    </button>
                    <button class="btn btn-primary" @click="remove()">
                        {{$t("system.remove")}}
                    </button>
            </template>
        </modal>
        <div>
            <div class="content-header h3">{{$t("university.departments")}}</div>
            <input v-model="filterData.text" class="filter_text_input"/>
            <button  class="btn btn-primary btn-sm" @click="getList">{{$t("system.search")}}</button>
            <div class="btn btn-primary btn-sm float-right" @click="$refs.modal.show()">
                {{$t("system.create")}}
            </div>
            <div class="row font-weight-light" style="font-size:0.7rem;margin-left: 3px">
                {{$tc("system.found_departments_number",total)}}
            </div>
            <Form ref="modal" v-on:update="getList"/>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="col-9">
                        {{$t("university.department.name")}}
                    </th>
                    <th class="col-1">
                        {{$t("university.department.alumni_number")}}
                    </th>
                    <th class="col-1">
                        {{$t("university.department.universities_number")}}
                    </th>
                    <th class="col-1">

                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="department in departments">
                    <td>{{department.name}}</td>
                    <td>{{department.alumnis.length}}</td>
                    <td>{{department.universities.length}}</td>
                    <td class="btn-group">
                        <button class="btn btn-sm btn-warning" @click="$refs.modal.show(department)">{{$t("system.edit")}}</button>
                        <button class="btn btn-danger btn-sm col-6 " v-if="department.universities.length ==0 && department.alumnis.length==0" @click="toremove=department;$refs.removeModal.show()"> {{$t("system.remove")}}</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
    import {get} from "../../api";
    import Form from "./Form.vue"
    export default {
        components:{
            Form:Form,
        },
        data(){
            return {
                filterData:{
                    text:""
                },
                departments:[],
                loading:true,
                scrollLoad:false,
                next_page_url:'/api/departments',
                base_url:'/api/departments',
                total:'',
                toremove:'',
            }
        },
        methods:{
            getList(){
                this.loading=true;
                let _this= this;
                _this.base_url = this.next_page_url ? this.next_page_url : null;
                if(this.base_url){
                    get(_this,_this.base_url,_this.filterData,
                        (res)=>{
                            if(res.data.current_page ===1){
                                _this.departments = [];
                            }
                            _this.total=res.data.total;
                            _this.departments = _this.departments.concat(res.data.data);
                            _this.loading=false;
                        },
                        (err)=>{}
                    )
                }
            },
            remove(){
                let _this=this;
                get(_this,"/api/department/remove/"+_this.toremove.id,{},
                    (res)=>{
                        _this.getList();
                        _this.$refs.removeModal.hide();
                        _this.toremove='';
                    },
                    (err)=>{}
                )
            }

        },
        mounted(){
            this.getList();
        }
    }
</script>

