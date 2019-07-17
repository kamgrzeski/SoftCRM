<template>
    <v-content>
        <div id="wrapper">
            <div id="page-wrapper">
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="page-header">
                                <small>Admin Profile:
                                    <span v-if="content"> {{ content.full_name }}</span>
                                </small>
                                <v-progress-linear :indeterminate="progressBar" v-if="progressBar"></v-progress-linear>
                            </h1>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#home" data-toggle="tab">Basic information</a></li>
                                <div class="text-right">
                                    <v-btn
                                            v-on:click="goToEditPage()"
                                            color="info"
                                            class="white--text store-button"
                                            :disabled="progressBar"
                                            :loading="progressBar"
                                    >
                                        Edit details
                                        <v-icon right dark>edit</v-icon>
                                    </v-btn>
                                    <v-btn
                                            data-toggle="modal"
                                            v-on:click="showDeleteModal()"
                                            color="orange"
                                            class="white--text store-button"
                                            :disabled="progressBar"
                                            :loading="progressBar"
                                    >
                                        Change password
                                    </v-btn>
                                </div>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="home">
                                    <table class="table table-striped table-bordered">
                                        <tbody class="text-right">
                                        <tr>
                                            <th>Full name</th>
                                            <td v-if="content">{{ content.full_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email address</th>
                                            <td v-if="content">{{ content.email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Username</th>
                                            <td v-if="content">{{ content.username }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td v-if="content">{{ content.phone }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
            this.getAdminDetails();
        },
        data() {
            return {
                content: [],
                warning: '',
                success: '',
                progressBar: false,
            }
        },
        props: [],
        computed: {},
        methods: {
            handleError(warning) {
                this.$toast.error(warning, 'Error');
            },

            handleSuccess(success) {
                this.$toast.success(success, 'OK');
            },

            getAdminDetails() {
                this.progressBar = true;

                this.$axios
                    .get(`./api/admin/profile`)
                    .then((response) => {
                        this.content = response.data.success.data;
                        this.progressBar = false;
                    })
                    .catch((error) => {
                        if (error.response.status === 422) {
                            this.warning = this.handleError(error.response.data.message);
                        } else if (error.response.data.error.message) {

                            this.warning = this.handleError(error.response.data.error.message);
                        } else {
                            this.warning = this.handleError('An error occurred while processing your request. Please try again.');
                        }
                        this.progressBar = false;
                    });
            },
        }
    }
</script>

<style>
    .text-right tr > th {
        padding: 17px !important;
        font-size: 16px;
    }
    .text-right tr > td {
        padding-top: 17SettingsModel has been changed.	px !important;
        font-size: 16px;
    }
</style>
