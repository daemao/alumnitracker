<template>
    <div >
        <div class="mb-3">
            <div class="">
                <Form ref="form" v-on:update="getList" />
                <div class="content-header h3">{{$t("system.Companies")}}</div>
                <input v-model="filterData.text" class="filter_text_input">
                <button @click="getList" class="btn btn-primary btn-sm">{{$t("system.search")}}</button>
                <div class="float-right">
                    <button class="btn btn-primary btn-sm " @click="$refs.form.show()"> {{$t("system.create")}} </button>
                </div>
            </div>
            <div class="row font-weight-light" style="font-size:0.7rem;margin-left: 3px">
                {{$tc('system.companies_found_number',total)}}
            </div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>
                </th>
                <th>{{$t("system.name")}}</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(company,index) in companies">
                <td >
                    {{index}}
                </td>
                <td>{{company.name}}</td>
                <td>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</template>
<script>
    import Form from "./Form.vue"
    import {get} from "../../api";
    export default {
        components:{
            Form:Form,
        },
        data(){
            return {
                filterData:{
                    text:""
                },
                companies:[],
                loading:true,
                scrollLoad:false,
                next_page_url:'/api/companies',
                base_url:'/api/companies',
                total:'',
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
                                _this.companies = [];
                            }
                            _this.total=res.data.total;
                            _this.companies = _this.companies.concat(res.data.data);
                            _this.loading=false;
                        },
                        (err)=>{}
                    )
                }
            }

        },
        mounted(){
            this.getList();
        }
    }
</script>
