<template>
    <div >
        <div  class="navbar fixed-bottom bg-secondary justify-content-between" v-if="selectedAlumni && selectedAlumni.length>0 || allUsers">
            <div class="navbar-brand"></div>
            <form class="form-inline">
                <span class="label float-left">{{$tc("system.with_selected",selectedAlumni.length)}} </span>
                <div class=" form-group">
                    <select v-model="selectedAlumniAction" class="form-control-sm">
                        <option value="export">{{$t("system.export_excel")}}</option>
                    </select>
                </div>
                <div class="btn btn-primary btn-sm" @click="massaction">{{$t('system.apply')}}</div>
            </form>
        </div>
        <MassactionSelectAlumni ref="massaction_select_alumni" :selected_ids="selectedAlumni" :action ="selectedAlumniAction"/>
        <div class="mb-3">
            <div class="">
                <Form ref="new_alumni" v-on:update="getList" />
                <GraduateInfoModal ref="graduate_info" v-on:update="getList"/>
                <div class="content-header h3">{{$t("alumni.list")}}</div>
                <input v-model="filterData.text" class="filter_text_input">
                <button @click="getList" class="btn btn-primary btn-sm">{{$t("system.search")}}</button>
                <div class="float-right">
                    <button class="btn btn-primary btn-sm " @click="$refs.new_alumni.show()"> {{$t("alumni.create")}} </button>
                </div>
            </div>
            <div class="row font-weight-light" style="font-size:0.7rem;margin-left: 3px">
                {{$tc('alumni.found_number',total)}}
            </div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>
                    <input type="checkbox" v-model="allUsers" @click = "selectAll">
                </th>
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
                    <button class="btn btn-primary btn-sm" @click="$router.push({name:'alumni-item',params:{id:user.id}})">{{$t("alumni.profile")}}</button>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</template>
<script>
    import Form from "./Form.vue"
    import GraduateInfoModal from "./modals/Graduate_information_info.vue"
    import MassactionSelectAlumni from "./modals/Massaction_select_alumni.vue"
    import {post,get} from "../../api";
    export default {
        components:{
            Form:Form,
            GraduateInfoModal,
            MassactionSelectAlumni
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
                allUsers:false,
                selectedAlumniAction:"export"
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
            massaction(){
                if(this.selectedAlumniAction =="export"){
                    if(this.allUsers)this.$refs.massaction_select_alumni.show();
                    else{
                        let form = {};
                        form.all_alumni = false;
                        form.alumni_list = this.selectedAlumni;
                        let _this = this;
                        post(_this,"/api/alumni/export-spreadsheet",form,
                            (res)=>{
                                window.open(res.data);
                            },
                            (err)=>{}
                        );
                    }
                }

            },
            selectAll(){
                this.selectedAlumni = [];
                this.$nextTick(()=>{
                    if(this.allUsers) {
                        this.selectedAlumni = this.users.map(el=>el.id);
                    }
                });

            }

        },
        mounted(){
            this.getList();
        }
    }
</script>
