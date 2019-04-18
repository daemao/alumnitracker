<template>
    <modal :title="$t('university.remove_header')" ref="modal">
        <template slot="body">
            {{$t('university.remove_body')}}
        </template>
        <template slot="footer">
            <button class="btn btn-secondary" @click="hide">{{$t('system.cancel')}}</button>
            <button class="btn btn-primary" @click="remove">{{$t('system.remove')}}</button>
        </template>
    </modal>
</template>
<script>
    import {post} from "../../../api";
    export default {
        props:["id"],
        methods:{
            show(){
                this.$refs.modal.show();
            },
            hide(){
                this.$refs.modal.hide();
            },
            remove(){
                let _this=this;
                post(_this,"/api/university-remove",{university_id:_this.id},(res)=>{
                    _this.hide();
                    _this.$emit("updated");
                },()=>{})
            }
        }
    }
</script>
