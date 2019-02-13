<template>
    <div>
        <Modal ref="form_modal"/>
        <div>
            Filter
            <div class="btn btn-primary" @click="$refs.form_modal.show()">Create new University</div>
        </div>
        <div>
            <div class="row" v-for="university in universities">{{university.name}}</div>
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

