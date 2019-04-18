<template>
    <div>
        <div class="mb-3">
            <div class="">
                <country-form ref="form_modal" v-on:update="$emit('update_common_data')"/>
                <div class="content-header h3">{{$t("system.countries")}}</div>
                <input v-model="filterData.text" class="filter_text_input">
                <button  class="btn btn-primary btn-sm" @click="getList">{{$t("system.search")}}</button>
                <div class="btn btn-primary btn-sm float-right" @click="$refs.form_modal.show()">{{$t("system.add")}}</div>
            </div>
            <div class="row font-weight-light" style="font-size:0.7rem;margin-left: 3px">
               {{$tc("system.found_countries_number",total)}}
            </div>
        </div>
        <div >
            <div class="row">
                <div class="col-5">{{$t("system.english_name")}}</div>
                <div class="col-5">{{$t("system.russian_name")}}</div>
                <div class="col"></div>
            </div>
            <div class = "row" v-for="country in countries">
                <div class="col-5">
                    <template v-if="country.translations">
                        <template v-for="t in country.translations" v-if="t.locale == 'en'">{{t.name}}</template>
                    </template>
                </div>
                <div class="col-5">
                    <template v-if="country.translations">
                        <template v-for="t in country.translations" v-if="t.locale == 'ru'">{{t.name}}</template>
                    </template>
                </div>
                <div class="col-1"> <div class="btn btn-warning" @click="$refs.form_modal.show(country.translations)"> {{$t("system.edit")}}</div></div>
                <div class="col-1"> <div class="btn btn-danger"> {{$t("system.remove")}}</div></div>
            </div>
        </div>
    </div>
</template>
<script>
    import Form from "./Form.vue";
    import {get} from "../../api";
    export default {
        data(){
          return{
              filterData:{
                  text:""
              },
              total:"",
              countries:[],
              loading:true,
              scrollLoad:false,
              next_page_url:'/api/countries',
              base_url:'/api/countries',
          }
        },
        components:{
            "country-form":Form
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
                                _this.countries = [];
                            }
                            _this.total=res.data.total;
                            _this.countries = _this.countries.concat(res.data.data);
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
