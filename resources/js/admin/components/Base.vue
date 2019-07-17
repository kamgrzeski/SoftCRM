<template>
    <div>
        <Sidebar></Sidebar>
        <v-content>
            <router-view :key="$route.path"></router-view>
        </v-content>
    </div>
</template>

<script>
    import Sidebar from "./views/Sidebar";

    export default {
        name: 'Base',
        components: {
            Sidebar
        },
        methods:{
            checkIfAdminIsAlreadyLoggedIn: function() {
                this.$axios
                    .get(`./api/admin/login/check`, [])
                    .catch((response) => {
                        this.$router.push('login');
                    })
            }
        },
        computed: {},
        beforeMount(){
            this.checkIfAdminIsAlreadyLoggedIn()
        }
    }
</script>
<style>
</style>
