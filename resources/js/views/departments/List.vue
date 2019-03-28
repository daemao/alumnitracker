<template>
    <div>
        <modal :title="$tc('departments.remove_modal_title')" ref="removeModal">
            <template slot="body">
                <div>
                    remove {{toremove.name}}
                </div>
            </template>
            <template slot="footer">
                    <button class="btn btn-secondary" @click= "toremove='';$refs.removeModal.hide()">
                        Cancel
                    </button>
                    <button class="btn btn-primary" @click="remove()">
                        Delete
                    </button>
            </template>
        </modal>
        <div>
            <div class="content-header h3">University departments</div>
            <input v-model="filterData.text" class="filter_text_input"/>
            <button  class="btn btn-primary btn-sm" @click="getList">Search</button>
            <div class="btn btn-primary btn-sm float-right" @click="$refs.modal.show()">
                Add department
            </div>
            <div class="row font-weight-light" style="font-size:0.7rem;margin-left: 3px">
                Found number of departments: {{total}}
            </div>
            <Form ref="modal" v-on:update="getList"/>
        </div>
        <table>
            <thead>
                <tr>
                    <th class="col-9">
                        {{$t("department.name")}}
                    </th>
                    <th class="col-1">
                        {{$t("department.alumni_number")}}
                    </th>
                    <th class="col-1">
                        {{$t("department.universities_number")}}
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
                        <button class="btn  btn-sm col-6 edit_button" @click="$refs.modal.show(department)"/>
                        <button class="btn btn-danger btn-sm col-6 " @click="toremove=department;$refs.removeModal.show()"> Delete</button>
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

