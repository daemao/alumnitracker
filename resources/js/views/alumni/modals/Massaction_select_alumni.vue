<template>
    <modal :title="$t('alumni.select_massaction')" ref="modal">
        <template slot="body">
            <div class="container">
                <div class="row">
                    <div class="col-6 card">
                        <div class="card-body">
                            <div class="card-title">all alumni</div>
                            <div class="card-body">Select all alumni that are in the database</div>
                            <div class="card-footer">
                                <div  class="btn btn-primary"  @click ="exportExcel('total')">Select</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 card">
                        <div class="card-body">
                            <div class="card-title">only loaded alumni</div>
                            <div class="card-body">Select only alumni that loaded to the list</div>
                            <div class="card-footer">
                                <div  class="btn btn-primary" @click ="exportExcel(null)">Select</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </modal>
</template>
<script>
    import {post} from "../../../api";
    export default {
        props:["selected_ids","action"],
        methods:{
            show(){
                this.$refs.modal.show();
            },
            hide(){
                this.$refs.modal.hide();
            },
            exportExcel(type){
                let form = {}
                if(type =="total"){
                    form.all_alumni = true;
                }else{
                    form.all_alumni = false;
                    form.alumni_list = this.selected_ids;
                }
                let _this = this;
                let url = this.action =="export"? '/api/alumni/export-spreadsheet':'/api/alumni/send-message';
                post(_this,url,form,
                    (res)=>{
                        window.open(res.data);
                        _this.hide();
                    },
                    (err)=>{}
                );
            }
        }
    }
</script>
