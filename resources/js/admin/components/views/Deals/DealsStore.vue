<template>
    <v-content>
        <div id="wrapper">
            <div id="page-wrapper">
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <v-progress-linear :indeterminate="progressBar" v-if="progressBar"></v-progress-linear>
                            <h1 class="page-header">
                                <small>Add deal</small>
                            </h1>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <form @submit.prevent="handleSubmit">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="full_name">Full name</label>
                                            <input class="form-control" name="full_name" type="text" id="full_name" v-validate="'required'" v-model="full_name">
                                            <div v-if="errors.has('full_name')" class="invalid-feedback">{{ errors.first('full_name') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input class="form-control" name="phone" type="text" id="phone" v-validate="'required'" v-model="phone">
                                            <div v-if="errors.has('phone')" class="invalid-feedback">{{ errors.first('phone') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="location">Location</label>
                                            <input class="form-control" name="location" type="text" id="location" v-validate="'required'" v-model="location">
                                            <div v-if="errors.has('location')" class="invalid-feedback">{{ errors.first('location') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="zip">Zip code</label>
                                            <input class="form-control" name="zip" type="text" id="zip" v-validate="'required'" v-model="zip">
                                            <div v-if="errors.has('zip')" class="invalid-feedback">{{ errors.first('zip') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="budget">Budget</label>
                                            <select class="form-control" name="budget" id="budget" v-model="budget" v-validate="'required'">
                                                <option value="1" selected>PLN</option>
                                                <option value="2">EUR</option>
                                                <option value="3">USD</option>
                                            </select>
                                            <div v-if="errors.has('budget')" class="invalid-feedback">{{ errors.first('budget') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="section">Section</label>
                                            <input class="form-control" name="section" type="text" id="section" v-validate="'required'" v-model="section">
                                            <div v-if="errors.has('section')" class="invalid-feedback">{{ errors.first('section') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input class="form-control" name="email" type="text" id="email" v-validate="'required', 'email'" v-model="email">
                                            <div v-if="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <input class="form-control" name="country" type="text" id="country" v-validate="'required'" v-model="country">
                                            <div v-if="errors.has('country')" class="invalid-feedback">{{ errors.first('country') }}</div>
                                        </div>
                                        <div class="form-group">
                                            <label for="country">City</label>
                                            <input class="form-control" name="city" type="text" id="city" v-validate="'required'" v-model="city">
                                            <div v-if="errors.has('city')" class="invalid-feedback">{{ errors.first('city') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <v-btn type="submit" color="primary">Add deal</v-btn>
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
            Footer,
        },
        mounted() {
        },
        created() {},
        data() {
            return {
                content: [],
                warning: '',
                success: '',
                progressBar: false,
                full_name: '',
                phone: '',
                location: '',
                zip: '',
                budget: '',
                email: '',
                country: '',
                section: '',
                city: ''
            }
        },
        props: [],
        computed: {},
        methods: {
            handleSubmit(e) {
                this.submitted = true;
                this.$validator.validate().then(valid => {
                    if (valid) {
                        this.storeClientData();
                    }
                });
            },
            handleError(warning) {
                this.$toast.error(warning, 'Error');
            },
            handleSuccess(success) {
                this.$toast.success(success, 'OK');
            },
            storeClientData() {
                this.progressBar = true;

                let data = {
                    full_name: this.full_name,
                    phone: this.phone,
                    location: this.location,
                    zip: this.zip,
                    budget: this.budget,
                    email: this.email,
                    section: this.section,
                    country: this.country,
                    city: this.city
                };

                this.progressBar = true;
                this.content = [];
                this.$axios
                    .post(`./api/deals/store`, data)
                    .then((response) => {
                        this.success = this.handleSuccess(response.data.success.message);
                        this.progressBar = false;
                        this.$router.push('/deals');
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
