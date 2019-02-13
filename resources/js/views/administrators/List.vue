<template>
    <div >
        <div class="mb-3">
            <div class="">
                <Form ref="new_admin" v-on:update="getList" />
                <input v-model="filterData.text" class=""  >
                <button @click="getList" class="btn btn-primary">Search</button>
                <button class="btn btn-primary float-right" @click="$refs.new_admin.show()"> Create administrator [TODO]</button>
            </div>
            <div class="row font-weight-light" style="font-size:0.7rem">
            Found number of administrators: {{total}}
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
            <router-link :key="'user'+user.id" v-for="(user,index) in users" :to="{name:'administrator',params:{id:user.id}}">
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
