<template>
    <div>
        <Modal ref="form_modal" v-on:updated="getList"/>
        <RemoveModal ref="remove_modal" :id="toRemove" v-on:updated="getList"/>
        <div>
            <div class="content-header h3">{{$t("system.universities")}}</div>
            <input v-model="filterData.text" class="filter_text_input"/>
            <button  class="btn btn-primary btn-sm" @click="getList">{{$t("system.search")}}</button>
            <div class="btn btn-primary btn-sm float-right" @click="$refs.form_modal.show()">
                {{$t("system.create")}}
            </div>
            <div class="row font-weight-light" style="font-size:0.7rem;margin-left: 3px">
                {{$tc("university.found_number",total)}}
            </div>
        </div>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{$t("system.english_name")}}</th>
                    <th>{{$t("system.russian_name")}}</th>
                    <th>{{$t("system.country")}}</th>
                    <th>{{$t("university.graduates_number")}}</th>
                    <th>{{$t("university.departments_number")}}</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <router-link :key="'university'+university.id" v-for="(university,index) in universities" :to="{name:'university',params:{id:university.id}}" tag="tr">
                    <td>{{index}}</td>
                    <td>
                        <template v-if="university.translations">
                            <template v-for="t in university.translations" v-if="t.locale == 'en'">{{t.name}}</template>
                        </template>
                    </td>
                    <td>
                        <template v-if="university.translations">
                            <template v-for="t in university.translations" v-if="t.locale == 'ru'">{{t.name}}</template>
                        </template>
                    </td>

                    <td>{{university.country.name}}</td>
                    <td>
                        {{university.alumni_number}}
                    </td>
                    <td>
                        {{university.departments_number}}
                    </td>
                    <td v-if="university.alumni_number==0 && university.departments_number==0">
                        <button class="btn btn-sm btn-danger" @click.prevent="toRemove=university.id; $refs.remove_modal.show()">  {{$t("system.remove")}}</button>
                    </td>
                </router-link>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    import {get} from "../../api";
    import Form from "./Form.vue";
    import RemoveModal from "./modals/RemoveModal.vue"
    export default {
        components:{
            Modal:Form,RemoveModal
        },
        data(){
            return {
                filterData:{
                    text:""
                },
                universities:[],
                loading:true,
                scrollLoad:false,
                next_page_url:'/api/universities',
                base_url:'/api/universities',
                total:'',
                toRemove:"",
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
                                _this.universities = [];
                            }
                            _this.total=res.data.total;
                            _this.universities = _this.universities.concat(res.data.data);
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

