<template>
</template>

<script>
    export default {
        mounted() {
        },
        created() {
            this.onPageLoad();
        },
        data() {
            return {
            }
        },
        props: [],
        computed: {},
        methods: {
            onPageLoad() {
                this.$axios
                    .get(`./api/admin/logout`, null)
                    .then((response) => {
                        this.$router.push({ path: '/login', query: { logout: true } });
                    })
            },
        }
    }

</script>