 <template>
    <div  >
        <Headbar v-if="$root.user" />
        <Sidebar v-if="$root.user && $root.user.data.role_id != 1" />
        <div class="content">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    import Sidebar  from "./components/Sidebar.vue";
    import Headbar from "./components/Headbar.vue";
    export default{
        components:{
            Sidebar,Headbar
        },
    }
</script>
