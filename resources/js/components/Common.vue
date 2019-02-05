<template>
    <div></div>
</template>

<script>
    import {get} from "../api";
    export default {
        data() {
            return {
                data: [],
            };
        },

        methods: {
            getData() {
                let component = this;
                get(component, "/api/data", {}, function(response) {
                    component.data = response.data;
                });
            },
        },
        created() {
            if (this.$auth.isAuthenticated()){
                this.getData();
            }
        },
    }




</script>

<style>
</style>
