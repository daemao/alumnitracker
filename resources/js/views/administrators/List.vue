<template>
    <div >
        <div class="mb-3">
            <div class="">
                <Form ref="new_admin" v-on:update="getList" />
                <div class="content-header h3">{{$t("administrators.list")}}</div>
                <input v-model="filterData.text" class="filter_text_input">
                <button @click="getList" class="btn btn-primary btn-sm">{{$t("system.search")}}</button>
                <button class="btn btn-primary btn-sm float-right" @click="$refs.new_admin.show()">{{$t("administrators.create")}} </button>
            </div>
            <div class="row font-weight-light" style="font-size:0.7rem;margin-left: 3px">
                {{$t('administrators.found_number')}}{{total}}
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{$t("alumni.first_name")}}</th>
                    <th>{{$t("alumni.last_name")}}</th>
                    <th>{{$t("alumni.email")}}</th>
                </tr>
            </thead>
            <tbody>
            <router-link :key="'user'+user.id" v-for="(user,index) in users" :to="{name:'administrator',params:{id:user.id}}" tag="tr">
                <td>{{index}}</td>
                <td>{{user.first_name}}</td>
                <td>{{user.last_name}}</td>
                <td>{{user.email}}</td>
            </router-link>
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
                users:[],
                loading:true,
                scrollLoad:false,
                next_page_url:'/api/users',
                base_url:'/api/users',
                total:''
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
                            _this.users = [];
                        }
                        _this.total=res.data.total;
                        _this.users = _this.users.concat(res.data.data);
                        _this.loading=false;
                        },
                        (err)=>{}
                    )
                }
            },

        },
        mounted(){
            this.getList();
        }
    }
</script>
