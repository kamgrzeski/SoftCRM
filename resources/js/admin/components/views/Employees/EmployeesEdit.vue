<template>
    <v-content>
        <div id="wrapper">
            <div id="page-wrapper">
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <v-progress-linear :indeterminate="progressBar" v-if="progressBar"></v-progress-linear>
                            <h1 class="page-header">
                                <small>Edit employee details: <span v-if="content"> {{ content.full_name }}</span></small>
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
                            <div class="row">
                                <form @submit.prevent="updateEmployeeData">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="full_name">Full name</label>
                                            <input class="form-control" name="full_name" type="text" id="full_name" v-model="content.full_name">
                                            <div v-if="errors.has('full_name')" class="invalid-feedback">{{ errors.first('full_name') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input class="form-control" name="phone" type="text" id="phone" v-model="content.phone">
                                            <div v-if="errors.has('phone')" class="invalid-feedback">{{ errors.first('phone') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input class="form-control" name="city" type="text" id="email" v-model="content.email">
                                            <div v-if="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="zip">Job</label>
                                            <input class="form-control" name="zip" type="text" id="zip" v-model="content.job">
                                            <div v-if="errors.has('job')" class="invalid-feedback">{{ errors.first('job') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="country">City</label>
                                            <input class="form-control" name="note" type="text" id="note" v-model="content.note">
                                            <div v-if="errors.has('note')" class="invalid-feedback">{{ errors.first('note') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <v-btn
                                                    type="submit"
                                                    color="primary"
                                                    dark
                                                    v-on="on"
                                            >
                                                Edit employee
                                            </v-btn>
                                        </div>
                                    </div>
                                </form>
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
            this.getEmployeesData();
        },
        data() {
            return {
                employeeId: this.$route.params.id,
                content: {
                    full_name: '',
                    phone: '',
                    location: '',
                    zip: '',
                    budget: '',
                    email: '',
                    country: '',
                    section: '',
                    city: ''
                },
                warning: '',
                success: '',
                progressBar: false,
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

            updateEmployeeData() {
                this.progressBar = true;

                let data = {
                    full_name: this.content.full_name,
                    phone: this.content.phone,
                    location: this.content.location,
                    zip: this.content.zip,
                    budget: this.content.budget,
                    email: this.content.email,
                    section: this.content.section,
                    country: this.content.country,
                    city: this.content.city
                };

                this.progressBar = true;
                this.content = [];
                this.$axios
                    .put(`./api/employees/update/` + this.employeeId, data)
                    .then((response) => {
                        this.success = this.handleSuccess(response.data.success.message);
                        this.progressBar = false;
                        this.$router.push('/employees/view/' + this.employeeId);
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
                    .get(`./api/employees/view/` + this.employeeId, [])
                    .then((response) => {
                        this.content = response.data.success.data.employeeDetails;
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
                        $('.panel-body').hide();

                        this.progressBar = false;
                    });
            },
        }
    }
</script>
