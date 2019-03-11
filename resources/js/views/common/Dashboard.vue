<template>
    <div v-if="!loading && $common.data && $common.data.nu_departments">
        <div class="mb-3">
            <div class="content-header h3">Dashboard</div>
        </div>
        <div class = "container ">
            <div class="row justify-content-between">
                <div class="col col-12 mb-4">
                    <div class="h4 text-center">Number of alumni per year in total</div>
                    <line-chart :data="alumniPerYear" min="0" xtitle="year" ytitle="alumnis number"></line-chart>
                </div>
                <div class="col col-5 mb-4">
                    <div class="h4 text-center">Gpa groups</div>
                <bar-chart :data="gpaDivisions"></bar-chart>
                </div>
                <div class="col col-5 mb-4">
                    <div class="h4 text-center">Alumni per school in total</div>
                    <bar-chart :data="AlumniPerSchool"></bar-chart>
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
                availableYears:""
            }
        },
        methods:{
            getAlumniTrend(){
                let _this = this;
                get(_this,"/api/dashboard/alumni-trend",{},(res)=>{
                    _this.alumniTrend = res.data;
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
            gpaDivisions(){
                let data=[["4.00",0],["3.00-3.99",0],["2.00-2.99",0],["1.00-1.99",0],["0.00-0.99",0]];
                this.alumniTrend.map(alumni=>{
                     data[4-Math.floor(alumni.cumulative_gpa)][1]+=1;
                });
                return data;
            },
            AlumniPerSchool(){
                let data=this.$common.data.nu_departments.map(dep=>{
                    return [dep.id,0]
                });
                this.alumniTrend.map(alumni=>{
                    data.forEach(el=>{
                        if(el[0] == alumni.department_id) el[1]+=1;
                    })
                });
                data.forEach(el=>{
                   this.$common.data.nu_departments.map(dep=>{
                       if(dep.id ==el[0])el[0]=dep.name;
                   })
                });
                return data;
            }

        }
    }
</script>
