<template>
    <v-content>
        <div id="wrapper">
            <div id="page-wrapper">
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <v-progress-linear :indeterminate="progressBar" v-if="progressBar"></v-progress-linear>
                            <h1 class="page-header">
                                <small>Employees list</small>
                                <v-btn
                                        v-on:click="goToEmployeeStoreTemplate()"
                                        color="green"
                                        class="white--text store-button"
                                        :disabled="progressBar"
                                        :loading="progressBar"
                                >
                                    Add new employee
                                    <v-icon right dark>cloud_upload</v-icon>
                                </v-btn>
                            </h1>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center-header">#</th>
                                    <th class="text-center-header">Full name</th>
                                    <th class="text-center-header">Phone</th>
                                    <th class="text-center-header">Email address</th>
                                    <th class="text-center-header">Job</th>
                                    <th class="text-center-header">Note</th>
                                    <th class="text-center-header">Status</th>
                                    <th class="text-center-header" style="width:200px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="odd gradeX" v-for="(item, index) in content">
                                    <td class="text-center">{{ index + 1 }}</td>
                                    <td class="text-center">{{ item.full_name }}</td>
                                    <td class="text-center">{{ item.phone }}</td>
                                    <td class="text-center">{{ item.email }}</td>
                                    <td class="text-center">{{ item.job }}</td>
                                    <td class="text-center">{{ item.note }}</td>
                                    <td class="text-center">
                                        <toggle-button :value="item.is_active === 1 ? true : false"
                                                       color="#D84315"
                                                       :sync="true"
                                                       :width="110"
                                                       :height="30"
                                                       :font-size="15"
                                                       :labels="{checked: 'Active', unchecked: 'Deactive'}"
                                                       class="toggle-button"
                                                       @change="disableEmployee(item.id, item.is_active)"/>
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <v-menu offset-y>
                                                <template v-slot:activator="{ on }">
                                                    <v-btn
                                                            color="orange"
                                                            dark
                                                            v-on="on"
                                                    >
                                                        More information
                                                    </v-btn>
                                                </template>
                                                <v-list>
                                                    <v-list-tile>
                                                        <router-link :to="{ name: 'employees/view', params: { id: item.id }}" class="blue--text">View</router-link>
                                                    </v-list-tile>
                                                    <v-list-tile>
                                                        <router-link :to="{ name: 'employees/edit', params: { id: item.id }}" class="green--text">Edit</router-link>
                                                    </v-list-tile>
                                                </v-list>
                                            </v-menu>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                content: [],
                warning: '',
                success: '',
                progressBar: true,
            }
        },
        props: [],
        computed: {},
        methods: {
            goToEmployeeStoreTemplate() {
              return this.$router.push('employees/add');
            },
            handleError(warning) {
                this.$toast.error(warning, 'Error');
            },
            handleSuccess(success) {
                this.$toast.success(success, 'OK');
            },
            disableEmployee(employeeId, type) {
                this.progressBar = true;
                this.$axios
                    .put(`./api/employees/set-active`, {employeeId: employeeId, type: type})
                    .then((response) => {
                        this.success = this.handleSuccess(response.data.success.message);
                        this.progressBar = false;
                        this.getEmployeesData();
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
            getEmployeesData() {
                this.progressBar = true;
                this.$axios
                    .get(`./api/employees/list`, [])
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
                    });
            },
        }
    }
</script>
<style>
    .toggle-button {
        margin-top: 10px;
    }
</style>
