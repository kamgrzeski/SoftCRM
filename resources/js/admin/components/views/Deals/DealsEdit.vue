<template>
    <v-content>
        <div id="wrapper">
            <div id="page-wrapper">
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <v-progress-linear :indeterminate="progressBar" v-if="progressBar"></v-progress-linear>
                            <h1 class="page-header">
                                <small>Edit deal details: <span v-if="content"> {{ content.full_name }}</span></small>
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
                            <div class="row">
                                <form @submit.prevent="updateDealData">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="full_name">Name</label>
                                            <input class="form-control" name="name" type="text" id="name" v-model="content.name">
                                            <div v-if="errors.has('name')" class="invalid-feedback">{{ errors.first('name') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Start time</label>
                                            <input class="form-control" name="start_time" type="text" id="start_time" v-model="content.start_time">
                                            <div v-if="errors.has('start_time')" class="invalid-feedback">{{ errors.first('start_time') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">End time</label>
                                            <input class="form-control" name="end_time" type="text" id="end_time" v-model="content.end_time">
                                            <div v-if="errors.has('end_time')" class="invalid-feedback">{{ errors.first('end_time') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="zip">companie</label>
                                            <input class="form-control" name="companies_id" type="text" id="companies_id" v-model="content.companies_id">
                                            <div v-if="errors.has('companies_id')" class="invalid-feedback">{{ errors.first('companies_id') }}</div>
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
                                                Edit deal
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
            this.getDealsData();
        },
        data() {
            return {
                dealId: this.$route.params.id,
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
            goToDealLists() {
                return this.$router.push('/deals');
            },

            handleError(warning) {
                this.$toast.error(warning, 'Error');
            },

            handleSuccess(success) {
                this.$toast.success(success, 'OK');
            },

            updateDealData() {
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
                    .put(`./api/deals/update/` + this.dealId, data)
                    .then((response) => {
                        this.success = this.handleSuccess(response.data.success.message);
                        this.progressBar = false;
                        this.$router.push('/deals/view/' + this.dealId);
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

            getDealsData() {
                this.progressBar = true;
                this.$axios
                    .get(`./api/deals/view/` + this.dealId, [])
                    .then((response) => {
                        this.content = response.data.success.data.dealDetails;
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
