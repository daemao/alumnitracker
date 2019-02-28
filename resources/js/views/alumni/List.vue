<template>
    <div >
        <div  class="navbar fixed-bottom bg-secondary justify-content-between">
            <div class="navbar-brand"></div>
            <form class="form-inline">
                <div class="form-group">
                    <div class="label">With selected {{selectedAlumni.length}}:</div>
                    <select v-model="selectedAlumniAction" class="form-control">
                        <option value="export">export excel</option>
                        <option value="email">send email</option>
                    </select>
                </div>
                <div class="btn btn-primary ">Apply</div>
            </form>
        </div>
        <div class="mb-3">
            <div class="">
                <Form ref="new_alumni" v-on:update="getList" />
                <GraduateInfoModal ref="graduate_info"/>
                <div class="content-header h3">{{$t("alumni.list")}}</div>
                <input v-model="filterData.text" class="filter_text_input">
                <button @click="getList" class="btn btn-primary btn-sm">{{$t("system.search")}}</button>
                <div class="float-right">
                    <button class="btn btn-primary btn-sm " @click="$refs.new_alumni.show()"> {{$t("alumni.create")}} </button>
                </div>
            </div>
            <div class="row font-weight-light" style="font-size:0.7rem;margin-left: 3px">
                {{$t('alumni.found_number')}}{{total}}
            </div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>{{$t("alumni.first_name")}}</th>
                <th>{{$t("alumni.last_name")}}</th>
                <th>{{$t("alumni.email")}}</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(user,index) in users">
                <td >
                    <input type="checkbox"  v-model="selectedAlumni" :value="user.id">
                </td>
                <td>{{user.first_name}}</td>
                <td>{{user.last_name}}</td>
                <td>{{user.email}}</td>
                <td>
                    <button class="btn btn-success btn-sm" @click="$refs.graduate_info.show(user.id)">{{$t("alumni.add_graduation_info")}}</button>
                    <button class="btn btn-primary btn-sm" @click="$router.push({name:'alumni-item',params:{id:user.id}})">profile</button>
                </td>
            </tr>
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
                total:'',
                selectedAlumni:[],
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
