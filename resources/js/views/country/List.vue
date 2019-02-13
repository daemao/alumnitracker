<template>
    <div>
        <div>
            There is a filter
            <div class="btn btn-primary" @click="$refs.form_modal.show()">Add  country</div>
            <country-form ref="form_modal"/>
        </div>
        <div >
            <div class="row">
                <div class="col">English name</div>
                <div class="col"></div>
            </div>
            <div class = "row" v-for="country in $common.data.countries">
                <div class="col-6">{{country.name}}</div>
                <div class="col-1"> <div class="btn btn-warning" @click="$refs.form_modal.show(country.translations)"> Edit</div></div>
                <div class="col-1"> <div class="btn btn-danger"> Delete</div></div>
            </div>
        </div>
    </div>
</template>
<script>
    import Form from "./Form.vue";
    export default {
        components:{
            "country-form":Form
        }
    }
</script>
