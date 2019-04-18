<template>
    <div v-if="!loading && $common.data && $common.data.nu_departments">
        <div class="mb-3">
            <div class="content-header h1">{{$tc("system.dashboard")}}</div>
        </div>
        <div class = "container ">
            <div class="row justify-content-between">
                <div class="col col-12 mb-4">
                    <div class="h4 text-center">{{$t("system.Dashboard.per_year_total")}}</div>
                    <line-chart :data="alumniPerYear" min="0" :xtitle="$t('system.Dashboard.year')" :ytitle="$t('university.graduates_number')"></line-chart>
                </div>
                <div class="col col-12 mb-4 bg-primary text-white">
                    <div  class="h2 text-left" > {{$t("system.Dashboard.total_users_number")}}</div>
                    <div  class="h1 text-left">{{totalGrads}}</div>
                </div>
                <div class="col col-3  mb-4 bg-success text-white">
                    <div  class="h2 text-left" >{{$t("system.Dashboard.working_total")}}</div>
                    <div  class="h1 text-left">{{totalWorking}}</div>
                </div>
                <div class="col col-3  offset-1 mb-4 bg-warning text-white">
                    <div  class="h2 text-left" > {{$t("system.Dashboard.studying_total")}}</div>
                    <div  class="h1 text-left">{{totalStudying}}</div>
                </div>
                <div class="col col-3  offset-1 mb-4 bg-danger text-white">
                    <div  class="h2 text-left" > {{$t("system.Dashboard.no_info_total")}}</div>
                    <div  class="h1 text-left">{{totalNoWorkInformation}}</div>
                </div>
            </div>
        </div>

    </div>
</template>
<style scoped>

</style>
<script>
    import {get} from "../../api";
    export default {
        data(){
            return {
                alumniTrend:{},
                loading:true,
                alumni:[],
                availableYears:""
            }
        },
        methods:{
            getAlumniTrend(){
                let _this = this;
                get(_this,"/api/dashboard/alumni-trend",{},(res)=>{
                    _this.alumniTrend = res.data.alumniTrend;
                    _this.alumni = res.data.alumni;
                    _this.loading=false;
                },()=>{

                })
            }
        },
        mounted(){
            this.availableYears = this.$root.getAvailableGraduationYears();
            this.getAlumniTrend();
        },
        computed:{
            alumniPerYear(){
                let data={};
                this.availableYears.map(year=>{
                    data[year]=0;
                });
                this.alumniTrend.map(alumni=>{
                    data[alumni.graduate_year]+=1;
                });
                return data;
            },
            totalGrads(){
                return this.alumni.length;
            },
            totalGradsWithoutAlumniInformation(){
                return this.alumni.filter(x=> !x.alumni_info).length;
            },
            totalWorking(){
                return this.alumni.filter(x=>x.status_id==2).length;
            },
            totalStudying(){
                return this.alumni.filter(x=>x.status_id==1).length;
            },
            totalNoWorkInformation(){
                return this.alumni.filter(x=>x.status_id==0).length;
            }
        }
    }
</script>
