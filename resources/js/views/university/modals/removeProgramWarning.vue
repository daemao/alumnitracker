<template>
    <modal ref="modal" title="Remove program">
        <template slot="body">
            remove program
        </template>
        <template slot="footer">
            <div class="btn btn-secondary">{{$t(system.cancel)}}</div>
            <div class="btn btn-danger">{{$t(system.delete)}}</div>
        </template>
    </modal>
</template>
<script>
    export default{
        props:["program_id","university_id"],
        methods:{
            show(){
                this.$refs.modal.show();
            },
            hide(){
                this.$refs.modal.hide();
            },
        }
    }
</script>
