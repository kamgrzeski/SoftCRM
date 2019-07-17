<template>
    <v-content>
        <div id="wrapper">
            <div id="page-wrapper">
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="page-header">
                                <small>Deal Details:
                                    <span v-if="content.dealDetails"> {{ content.dealDetails.full_name }}</span>
                                </small>
                                <v-progress-linear :indeterminate="progressBar" v-if="progressBar"></v-progress-linear>
                                <v-btn
                                        v-on:click="goToDealLists()"
                                        color="lime darken-2"
                                        class="white--text store-button"
                                        :disabled="progressBar"
                                        :loading="progressBar"
                                >
                                    Back to list
                                    <v-icon right dark>settings_backup_restore</v-icon>
                                </v-btn>
                            </h1>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#home" data-toggle="tab">Basic information</a>
                                </li>
                                <div class="text-right">
                                    <v-btn
                                            v-on:click="goToEditPage()"
                                            color="info"
                                            class="white--text store-button"
                                            :disabled="progressBar"
                                            :loading="progressBar"
                                    >
                                        Edit this deal
                                        <v-icon right dark>edit</v-icon>
                                    </v-btn>
                                    <v-btn
                                            data-toggle="modal"
                                            v-on:click="showDeleteModal()"
                                            color="red"
                                            class="white--text store-button"
                                            :disabled="progressBar"
                                            :loading="progressBar"
                                    >
                                        Delete this deal
                                        <v-icon right dark>delete_forever</v-icon>
                                    </v-btn>
                                </div>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="home">
                                    <table class="table table-striped table-bordered">
                                        <tbody class="text-right">
                                        <tr>
                                            <th>Name</th>
                                            <td v-if="content.dealDetails">{{ content.dealDetails.name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Start time</th>
                                            <td v-if="content.dealDetails">{{ content.dealDetails.start_time }}</td>
                                        </tr>
                                        <tr>
                                            <th>End time</th>
                                            <td v-if="content.dealDetails">{{ content.dealDetails.end_time }}</td>
                                        </tr>
                                        <tr>
                                            <th>companies id</th>
                                            <td v-if="content.dealDetails">{{ content.dealDetails.companies_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td v-if="content.dealDetails">{{ content.dealDetails.is_active === 1 ? 'Yes' : 'No'  }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <v-layout row justify-center>
                        <v-dialog
                                v-model="dialog"
                                max-width="550"
                        >
                            <v-card>
                                <v-card-title class="headline grey lighten-2">
                                    Would You like to delete this deal?
                                </v-card-title>

                                <v-card-actions>
                                    <v-spacer></v-spacer>

                                    <v-btn
                                            color="red darken-1"
                                            flat="flat"
                                            @click="dialog = false"
                                    >
                                        NO, CANCEL
                                    </v-btn>

                                    <v-btn
                                            color="green darken-1"
                                            flat="flat"
                                            @click="deleteDeal"
                                    >
                                        YES, CONFIRM
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-layout>
                    <Footer></Footer>
                </div>
            </div>
        </div>
    </v-content>
</template>

<script>
    import DealsStore from "./DealsStore";
    import Footer from "./../Footer";

    export default {
        components: {
            Footer,
            DealsStore
        },
        mounted() {
        },
        created() {
            this.getDealsData();
        },
        data() {
            return {
                dealId: this.$route.params.id,
                content: [],
                warning: '',
                success: '',
                progressBar: true,
                dialog: false
            }
        },
        props: [],
        computed: {},
        methods: {
            goToDealLists() {
                return this.$router.push('/deals');
            },
            handleError(warning) {
                this.$toast.error(warning, 'Error');
            },
            handleSuccess(success) {
                this.$toast.success(success, 'OK');
            },
            goToEditPage() {
                this.$router.push({ name: 'deals/edit', params: { id: this.dealId } });
            },

            getDealsData() {
                this.progressBar = true;
                this.$axios
                    .get(`./api/deals/view/` + this.dealId, [])
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
                            this.warning = this.handleError('Server error');
                        }
                        this.progressBar = false;
                        $('.panel-body').hide();
                    });
            },
            showDeleteModal() {
                this.dialog = true
            },
            deleteDeal() {
                this.progressBar = true;
                this.$axios
                    .delete('./api/deals/delete/'  + this.dealId, {})
                    .then((response) => {
                        this.message = this.handleSuccess(response.data.success.message);
                        this.progressBar = false;
                        this.$router.push('/deals');

                    })
                    .catch((error) => {
                        if (error.response.status === 422) {
                            this.warning = this.handleError(error.response.data.message);
                        } else if (error.response.data.error.message) {

                            this.warning = this.handleError(error.response.data.error.message);
                        } else {
                            this.warning = this.handleError('Server error');
                        }
                        this.progressBar = false;
                    });
                this.dialog = false;
            }
        }
    }
</script>
<style>
    .table {
        margin-top: 10px;
    }
</style>