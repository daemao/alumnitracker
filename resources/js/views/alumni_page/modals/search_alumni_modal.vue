<template>
    <modal title="add program" ref="modal">
        <template slot="body">
            <div class="form">
                <div class="form-group">
                    <label>{{$t("system.search")}}</label>
                    <input v-model="form.text" class="form-control"/>
                </div>
                <div class="btn btn-block btn-primary" @click="getAlumniList()">
                    {{$t("system.search")}}
                </div>
            </div>
            <div class="table-responsive">
                <table class=" table" v-if="users && users.length>0">
                    <thead>
                    <tr >
                        <th></th>
                        <th>{{$t("alumni.first_name")}}</th>
                        <th>{{$t("alumni.last_name")}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users" >
                        <td >
                            <input type="checkbox"  v-model="selected_users" :value="user.id">
                        </td>
                        <td>
                            {{user.first_name}}
                        </td>
                        <td>
                            {{user.last_name}}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </template>
        <template slot="footer">
            <button class="btn btn-secondary" @click="hide">{{$t('system.cancel')}}</button>
            <button class="btn btn-primary" @click="addFriends" :disabled="!selected_users || selected_users.length==0">{{$t('system.add')}}</button>
        </template>
    </modal>
</template>
<script>
    import {post,get} from "../../../api";
    import Tab from "bootstrap-vue/es/components/tabs/tab";
    export default {
        components: {Tab},
        props:["user_id"],
        data(){
            return{
                form:{
                    current_user:this.user_id,
                    text:""
                },
                selected_users:[],
                users:[],
            }
        },
        methods:{
            show(){
                this.$refs.modal.show();
            },
            hide(){
                this.$refs.modal.hide();
            },
            addFriends(){
                let _this=this;
                let _newForm = {
                    users:_this.selected_users
                }
                post(_this,"/api/alumni/start-follow",_newForm,
                    (res)=>{
                        _this.$emit("update");
                        _this.hide()
                    },
                    ()=>{}
                )
            },
            getAlumniList(){
                let _this=this;
                get(_this,"/api/alumni/get-list-to-follow",_this.form,
                    (res)=>{
                        _this.users=res.data
                    },
                    ()=>{}
                )
            }

        }
    }
</script>
