<template>
    <div>
        <Modal ref="form_modal"/>
        <div>
            <div class="content-header h3">Universities</div>
            <input v-model="filterData.text" class="filter_text_input"/>
            <button  class="btn btn-primary btn-sm" @click="getList">Search</button>
            <div class="btn btn-primary btn-sm float-right" @click="$refs.form_modal.show()">
                Create university
            </div>
            <div class="row font-weight-light" style="font-size:0.7rem;margin-left: 3px">
                Found number of countries: {{total}}
            </div>
        </div>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Country</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <router-link :key="'university'+university.id" v-for="(university,index) in universities" :to="{name:'university',params:{id:university.id}}" tag="tr">
                    <td>{{index}}</td>
                    <td>{{university.name}}</td>
                    <td>{{university.country.name}}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" @click.prevent=""> edit</button>
                        <button class="btn btn-sm btn-danger" @click.prevent=""> remove</button>
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
    export default {
        components:{
            Modal:Form
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
                total:''
            }
        },
        methods:{
            getList(){
                this.loading=true;
                let _this= this;
                _this.base_url = this.next_page_url ? this.next_page_url : null;
                if(this.base_url){
                    get(_this,_this.base_url,{},
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
            },

        },
        mounted(){
            this.getList();
        }
    }
</script>

