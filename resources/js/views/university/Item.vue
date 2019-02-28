<template>
    <div v-if="university">
        <div class="content-header h3">{{university.name}}</div>
        <removeProgramWarning ref="removeProgramWarningRef"/>
        <addProgramToUniversity ref="addProgramToUniversityRef"  :university="university" />
        <div class="container row">
            <div class="col-6">
                <div>
                    <div class="h6"> General information</div>
                    <div class="row">
                        <div class="col-4">Country</div>
                        <div class="col-8">{{university.country.name}}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4"> Programs:</div>
                    <div class="col-8">
                        <template v-for="program in university.programs">{{program.name}}&nbsp</template>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="h6 text-center"> Departments in University<span class="badge badge-primary ml-4" @click="$refs.addProgramToUniversityRef.show()">add departments</span></div>
                <div v-for="program in university.programs" class="mb-4">
                    <div class="h6"> {{program.name}} departments</div>
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
