<template>
    <b-modal id="modal" :title="title" v-model = "showModal" hide-footer>
        <div class="modal-body">
            <slot name="body" />
        </div>
        <div class="modal-footer">
            <slot name="footer"/>
        </div>
    </b-modal>
</template>
<!--there will be template for all modals in project-->
<script>

    export default{
        props:["title"],
        data(){
            return{
                showModal:false
            }
        },
        methods:{
            show(){
                this.showModal=true;
            },
            hide(){
                this.showModal=false;
            }
        }
    }
</script>
