<template>
    <nav >
        <div class="">
        <ul class="">
            <router-link :to="{path:'/dashboard'}" :class="{'sidebar_link-current':links.dashboard.indexOf($route.name)>-1}" class="nav-item sidebar_link sidebar_link-dashboard">{{$t('system.dashboard')}}</router-link>
            <router-link :to="{path:'/alumni'}" :class="{'sidebar_link-current':links.alumni.indexOf($route.name)>-1}" class="nav-item sidebar_link sidebar_link-alumni">Alumni</router-link>
            <router-link :to="{path:'/administrators'}" :class="{'sidebar_link-current':links.administrators.indexOf($route.name)>-1}" class="nav-item sidebar_link sidebar_link-administration">Administrators</router-link>
            <router-link :to="{path:'/universities'}" :class="{'sidebar_link-current':links.universities.indexOf($route.name)>-1}" class="nav-item sidebar_link sidebar_link-universities">Universities</router-link>
            <router-link :to="{path:'/countries'}" :class="{'sidebar_link-current':links.countries.indexOf($route.name)>-1}" class="nav-item sidebar_link sidebar_link-countries">Countries</router-link>
            <router-link :to="{path:'/departments'}" :class="{'sidebar_link-current':links.departments.indexOf($route.name)>-1}" class="nav-item sidebar_link sidebar_link-departments">Departments</router-link>

        </ul>
        </div>
    </nav>
</template>
<script>
    export default {
        data(){
            return {
                links:{
                    dashboard:["dashboard"],
                    alumni:["alumni-list"],
                    administrators:["administrators","administrator"],
                    universities:["universities"],
                    countries:["countries"],
                    departments:["departments"]
                }

            }
        }
    }
</script>
