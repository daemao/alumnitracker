<template>
    <modal ref="modal" title="New graduate information">
        <template slot="body">
            <div class="form">
                <div class="form-group">
                    <label for=""></label>
                </div>
            </div>
        </template>
        <template slot="footer">

        </template>
    </modal>
</template>
<script>
    export default {
        methods:{
            show(){
                this.$refs.modal.show();
            },
            hide(){
                this.$refs.modal.hide();
            }
        }
    }
</script>
