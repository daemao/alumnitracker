<template>
    <modal :title="$t('system.country_edit')" ref="modal">
        <template slot="body">
            <form>
                <div class="form-group row" v-for="(country,index) in translations">
                    <div class="col-3">
                        <select class="custom-select" v-model="country.locale" >
                            <option value="en">en</option>
                            <option value="ru">ру</option>
                        </select>
                    </div>
                    <div class="col-7">
                        <input class="form-control" type="text" v-model="country.name"/>
                    </div>
                    <div class="col-2" @click="translations.splice(index,1)">{{$t("system.remove")}}</div>
                </div>
                <div class="btn btn-primary btn-block" v-if="translations.length<2" @click="newTranslation"> {{$t("system.new_translation")}}</div>
            </form>
        </template>
        <template slot="footer">
            <div class="btn btn-secondary" @click="hide"> cancel</div>
            <div class="btn btn-primary" @click="sendForm">
                {{translations && translations[0] && translations[0].country_id ? $t("system.update"):$t("system.create")}}
            </div>
        </template>
    </modal>
</template>
<script>
    import {post} from "../../api";
    export default {
        data(){
          return {
              translations:[{
                  name:"",
                  locale:"en"
              }]
          }
        },
        methods:{
            hide(){
              this.$refs.modal.hide();
            },
            show(el){
                if(el)this.translations=el;
                this.$refs.modal.show();
            },
            sendForm(){
                let _this=this;
                post(_this,"/api/country/save",{translations:this.translations},
                    (res)=>{
                        _this.$emit("update");
                    },
                    ()=>{});
            },
            newTranslation(){
                if(this.translations.length===0){
                    this.translations.push({locale:"en"});
                }else{
                    this.translations.push({locale:this.translations[0].locale =='ru'?'en':'ru'})
                }
            },
        }
    }
</script>
