<template>
    <v-content>
        <div id="wrapper">
            <div id="page-wrapper">
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="page-header">
                                <small>Employee Details:
                                    <span v-if="content.employeeDetails"> {{ content.employeeDetails.full_name }}</span>
                                </small>
                                <v-progress-linear :indeterminate="progressBar" v-if="progressBar"></v-progress-linear>
                                <v-btn
                                        v-on:click="goToEmployeeLists()"
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
                                        Edit this employee
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
                                        Delete this employee
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
                                            <td v-if="content.employeeDetails">{{ content.employeeDetails.full_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td v-if="content.employeeDetails">{{ content.employeeDetails.phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email address</th>
                                            <td v-if="content.employeeDetails">{{ content.employeeDetails.email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Job</th>
                                            <td v-if="content.employeeDetails">{{ content.employeeDetails.job }}</td>
                                        </tr>
                                        <tr>
                                            <th>Note</th>
                                            <td v-if="content.employeeDetails">{{ content.employeeDetails.note }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td v-if="content.employeeDetails">{{ content.employeeDetails.is_active === 1 ? 'Yes' : 'No'  }}</td>
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
                                    Would You like to delete this employee?
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
                                            @click="deleteEmployee"
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
    import EmployeesStore from "./EmployeesStore";
    import Footer from "./../Footer";

    export default {
        components: {
            Footer,
            EmployeesStore
        },
        mounted() {
        },
        created() {
            this.getEmployeesData();
        },
        data() {
            return {
                employeeId: this.$route.params.id,
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
            goToEmployeeLists() {
                return this.$router.push('/employees');
            },
            handleError(warning) {
                this.$toast.error(warning, 'Error');
            },
            handleSuccess(success) {
                this.$toast.success(success, 'OK');
            },
            goToEditPage() {
                this.$router.push({ name: 'employees/edit', params: { id: this.employeeId } });
            },

            getEmployeesData() {
                this.progressBar = true;
                this.$axios
                    .get(`./api/employees/view/` + this.employeeId, [])
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
            deleteEmployee() {
                this.progressBar = true;
                this.$axios
                    .delete('./api/employees/delete/'  + this.employeeId, {})
                    .then((response) => {
                        this.message = this.handleSuccess(response.data.success.message);
                        this.progressBar = false;
                        this.$router.push('/employees');

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