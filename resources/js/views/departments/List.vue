<template>
    <div>
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
            <Form ref="modal"/>
        </div>
        <div>
            <div class="row" v-for="department in departments">{{department.name}}</div>
        </div>
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

        },
        mounted(){
            this.getList();
        }
    }
</script>

