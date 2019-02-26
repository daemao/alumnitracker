<template>
    <div >
        <div class="mb-3">
            <div class="">
                <Form ref="new_alumni" v-on:update="getList" />
                <GraduateInfoModal ref="graduate_info"/>
                <div class="content-header h3">Alumni</div>
                <input v-model="filterData.text" class="filter_text_input">
                <button @click="getList" class="btn btn-primary btn-sm">Search</button>
                <button class="btn btn-primary btn-sm float-right" @click="$refs.new_alumni.show()"> Create alumni </button>
            </div>
            <div class="row font-weight-light" style="font-size:0.7rem;margin-left: 3px">
                Found number of alumni: {{total}}
            </div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <router-link :key="'user'+user.id" v-for="(user,index) in users" :to="{name:'alumni',params:{id:user.id}}" tag="tr">
                <td>{{index}}</td>
                <td>{{user.first_name}}</td>
                <td>{{user.last_name}}</td>
                <td>{{user.email}}</td>
                <td>
                    <button class="btn btn-success btn-sm" @click.prevent="$refs.graduate_info.show()">Add graduation info</button>
                </td>
            </router-link>
            </tbody>
        </table>

    </div>
</template>
<script>
    import {get} from "../../api";
    import Form from "./Form.vue"
    import GraduateInfoModal from "./modals/Graduate_information_info.vue"
    export default {
        components:{
            Form:Form,
            GraduateInfoModal,
        },
        data(){
            return {
                filterData:{
                    text:""
                },
                users:[],
                loading:true,
                scrollLoad:false,
                next_page_url:'/api/alumni',
                base_url:'/api/alumni',
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
