<template>
    <v-content>
        <div id="wrapper">
            <div id="page-wrapper">
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="page-header">
                                <small>Client Details:
                                    <span v-if="content.clientDetails"> {{ content.clientDetails.full_name }}</span>
                                </small>
                                <v-progress-linear :indeterminate="progressBar" v-if="progressBar"></v-progress-linear>
                                <v-btn
                                        v-on:click="goToClientLists()"
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
                                <li><a href="#companies" data-toggle="tab">
                                    <v-badge color="green">
                                        <template v-slot:badge>
                                            <span v-if="content.clientDetails">{{ content.clientDetails.assignedCompaniesCount }}</span>
                                        </template>
                                        <span>Assigned companies</span>
                                    </v-badge>
                                </a>
                                </li>
                                <li><a href="#employees" data-toggle="tab">
                                    <v-badge color="green">
                                        <template v-slot:badge>
                                            <span v-if="content.clientDetails">{{ content.clientDetails.assignedEmployeesCount }}</span>
                                        </template>
                                        <span>Assigned employees</span>
                                    </v-badge>
                                </a>
                                </li>
                                <div class="text-right">
                                    <v-btn
                                            v-on:click="goToEditPage()"
                                            color="info"
                                            class="white--text store-button"
                                            :disabled="progressBar"
                                            :loading="progressBar"
                                    >
                                        Edit this client
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
                                        Delete this client
                                        <v-icon right dark>delete_forever</v-icon>
                                    </v-btn>
                                </div>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="home">
                                    <table class="table table-striped table-bordered">
                                        <tbody class="text-right">
                                        <tr>
                                            <th>Full name</th>
                                            <td v-if="content.clientDetails">{{ content.clientDetails.full_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td v-if="content.clientDetails">{{ content.clientDetails.phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email address</th>
                                            <td v-if="content.clientDetails">{{ content.clientDetails.email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Section</th>
                                            <td v-if="content.clientDetails">{{ content.clientDetails.section }}</td>
                                        </tr>
                                        <tr>
                                            <th>Budget</th>
                                            <td v-if="content.clientDetails">{{ content.clientDetails.budget }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td v-if="content.clientDetails">{{ content.clientDetails.is_active === 1 ? 'Yes' : 'No'  }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="companies">
                                    <h4>List of companies</h4>
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Tax number</th>
                                            <th>Active</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="active" v-for="item in content.assignedCompaniesDetails">
                                            <td>{{ item.name }}</td>
                                            <td>{{ item.phone }}</td>
                                            <td>{{ item.tax_number }}</td>
                                            <td>{{ item.is_active === 1 ? 'Yes' : 'No'  }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="employees">
                                    <h4>List of employeees</h4>
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>Full name</th>
                                            <th>Phone</th>
                                            <th>Email address</th>
                                            <th>Job</th>
                                            <th>Active</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="active" v-for="item in content.assignedEmployeesDetails">
                                            <td>{{ item.full_name }}</td>
                                            <td>{{ item.phone }}</td>
                                            <td>{{ item.email }}</td>
                                            <td>{{ item.job }}</td>
                                            <td>{{ item.is_active === 1 ? 'Yes' : 'No'  }}</td>
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
                                    Would You like to delete this client?
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
                                            @click="deleteClient"
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
    import ClientStore from "./ClientsStore";
    import Footer from "./../Footer";

    export default {
        components: {
            Footer,
            ClientStore
        },
        mounted() {
        },
        created() {
            this.getClientsData();
        },
        data() {
            return {
                clientId: this.$route.params.id,
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
            goToClientLists() {
                return this.$router.push('/clients');
            },
            handleError(warning) {
                this.$toast.error(warning, 'Error');
            },
            handleSuccess(success) {
                this.$toast.success(success, 'OK');
            },
            goToEditPage() {
                this.$router.push({ name: 'clients/edit', params: { id: this.clientId } });
            },

            getClientsData() {
                this.progressBar = true;
                this.$axios
                    .get(`./api/clients/view/` + this.clientId, [])
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
            deleteClient() {
                this.progressBar = true;
                this.$axios
                    .delete('./api/clients/delete/'  + this.clientId, {})
                    .then((response) => {
                        this.message = this.handleSuccess(response.data.success.message);
                        this.progressBar = false;
                        this.$router.push('/clients');

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