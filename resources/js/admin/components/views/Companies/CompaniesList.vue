<template>
    <v-content>
        <div id="wrapper">
            <div id="page-wrapper">
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="page-header">
                                <small style="color: black">Companies</small>
                            </h1>
                        </div>
                    </div>
                    <Footer></Footer>
                </div>
            </div>
        </div>
    </v-content>
</template>

<script>
    import Footer from "./../Footer";

    export default {
        components: {
            Footer
        },
        mounted() {
        },
        created() {
        },
        data() {
            return {
                content: []
            }
        },
        props: [],
        computed: {},
        methods: {}
    }
</script>
