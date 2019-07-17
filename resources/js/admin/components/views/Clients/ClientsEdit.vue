<template>
    <v-content>
        <div id="wrapper">
            <div id="page-wrapper">
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <v-progress-linear :indeterminate="progressBar" v-if="progressBar"></v-progress-linear>
                            <h1 class="page-header">
                                <small>Edit client details: <span v-if="content"> {{ content.full_name }}</span></small>
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
                            <div class="row">
                                <form @submit.prevent="updateClientData">
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
                                            <label for="location">Location</label>
                                            <input class="form-control" name="location" type="text" id="location" v-model="content.location">
                                            <div v-if="errors.has('location')" class="invalid-feedback">{{ errors.first('location') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="zip">Zip code</label>
                                            <input class="form-control" name="zip" type="text" id="zip" v-model="content.zip">
                                            <div v-if="errors.has('zip')" class="invalid-feedback">{{ errors.first('zip') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="budget">Budget</label>
                                            <select class="form-control" id="budget" v-model="content.budget">
                                                <option value="1">PLN</option>
                                                <option value="2">EUR</option>
                                                <option value="3">USD</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="section">Section</label>
                                            <input class="form-control" name="section" type="text" id="section" v-model="content.section">
                                            <div v-if="errors.has('section')" class="invalid-feedback">{{ errors.first('section') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input class="form-control" name="city" type="text" id="email" v-model="content.email">
                                            <div v-if="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <input class="form-control" name="country" type="text" id="country" v-model="content.country">
                                            <div v-if="errors.has('country')" class="invalid-feedback">{{ errors.first('country') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="country">City</label>
                                            <input class="form-control" name="city" type="text" id="city" v-model="content.city">
                                            <div v-if="errors.has('city')" class="invalid-feedback">{{ errors.first('city') }}</div>
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
                                                Edit client
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
            this.getClientsData();
        },
        data() {
            return {
                clientId: this.$route.params.id,
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
            goToClientLists() {
                return this.$router.push('/clients');
            },

            handleError(warning) {
                this.$toast.error(warning, 'Error');
            },

            handleSuccess(success) {
                this.$toast.success(success, 'OK');
            },

            updateClientData() {
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
                    .put(`./api/clients/update/` + this.clientId, data)
                    .then((response) => {
                        this.success = this.handleSuccess(response.data.success.message);
                        this.progressBar = false;
                        this.$router.push('/clients/view/' + this.clientId);
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

            getClientsData() {
                this.progressBar = true;
                this.$axios
                    .get(`./api/clients/view/` + this.clientId, [])
                    .then((response) => {
                        this.content = response.data.success.data.clientDetails;
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
