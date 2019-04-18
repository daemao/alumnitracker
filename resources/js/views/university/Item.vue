<template>
    <div v-if="university">
        <div class="content-header h3">{{university.name}}</div>
        <addProgramToUniversity ref="addProgramToUniversityRef"  :university="university" v-on:update="getItem"/>
        <div class="container row">
            <div class="col-6">
                <div>
                    <div class="row">
                        <div class="col-4">{{$t("university.country")}}</div>
                        <div class="col-8">{{university.country.name}}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8"> {{$t("university.graduates_number")}}</div>
                    <div class="col-4">
                        {{university.alumni_number}}
                    </div>
                </div>
                <div class="h2"> {{$t("university.Programs")}}:</div>
                <div class="row">
                    <div class="col-12"  v-for="program in university.programs">
                        {{program.name}}
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="h2 text-center"> {{$t("university.departments")}}<span class="btn btn-primary btn-sm float-right" @click="$refs.addProgramToUniversityRef.show()">{{$t("system.add")}}</span></div>
                <div v-for="program in university.programs" class="mb-4">
                    <div class="h5"> {{program.name}}</div>
                    <div class="container">
                    <div class="row" v-for="department in university.departments" v-if="department.pivot.program_id === program.id">
                        <li >{{department.name}}</li>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {get} from "../../api";
    import removeProgramWarning from "./modals/removeProgramWarning.vue"
    import addProgramToUniversity from "./modals/addProgramToUniversity.vue"
    export default {
        props:["id"],
        data(){
            return {
                university:"",
                loading:true
            }
        },
        components:{
            removeProgramWarning,
            addProgramToUniversity
        },
        methods:{
            getItem(){
                let _this = this;
                this.loading=true;
                get(_this,"/api/university/"+this.id,{},
                    (res)=>{
                        this.university = res.data;
                        this.loading = false;
                    },
                    (err)=>{}
                );
            },
        },
        created(){
            this.getItem();
        }

    }
</script>
