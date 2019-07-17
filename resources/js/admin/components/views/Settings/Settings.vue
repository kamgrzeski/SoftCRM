<template>
    <v-content>
        <div id="wrapper">
            <div id="page-wrapper">
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="page-header">
                                <small>Settings</small>
                            </h1>
                            <v-progress-linear :indeterminate="progressBar" v-if="progressBar"></v-progress-linear>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="row">
                                                <form>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="pagination_size">Pagination size</label>
                                                            <input class="form-control"
                                                                   v-model="settings.pagination_size"
                                                                   name="pagination_size" type="text"
                                                                   id="pagination_size">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="priority_size">Priority size</label>
                                                            <input class="form-control" v-model="settings.priority_size"
                                                                   name="priority_size" type="text" id="priority_size">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="currency">Currency type</label>
                                                            <select class="form-control" v-model="settings.currency"
                                                                    id="currency" name="currency">
                                                                <option value="PLN">PLN</option>
                                                                <option value="EUR">EUR</option>
                                                                <option value="USD" selected="selected">USD</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="invoice_tax">Tax</label>
                                                            <input class="form-control" v-model="settings.invoice_tax"
                                                                   name="invoice_tax" type="text" id="invoice_tax">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="stats">Statistic (left panel)</label>
                                                            <select class="form-control" v-model="settings.stats"
                                                                    id="stats" name="stats">
                                                                <option value="1" selected="selected">Yes</option>
                                                                <option value="2">No</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <v-btn
                                                                v-on:click="storeSettingsData()"
                                                                color="#3f7cb1"
                                                                class="white--text"
                                                                :disabled="progressBar"
                                                                :loading="progressBar"
                                                        >
                                                            Save settings
                                                        </v-btn>
                                                    </div>
                                                </form>
                                                <!-- /.row (nested) -->
                                            </div>

                                            <!-- /.panel-body -->
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h4>System logs</h4>
                                                    <br>
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>User Id</th>
                                                            <th>Action</th>
                                                            <th>City</th>
                                                            <th>Country</th>
                                                            <th>IP Address</th>
                                                            <th>Date</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr class="active" v-for="item in content">
                                                            <td>{{ item.user_id }}</td>
                                                            <td>{{ item.actions }}</td>
                                                            <td>{{ item.city }}</td>
                                                            <td>{{ item.country }}</td>
                                                            <td>{{ item.ip_address }}</td>
                                                            <td>{{ item.date }}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- /.row (nested) -->
                                            </div>
                                            <!-- /.panel-body -->
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                </div>
                                <!-- /.col-lg-12 -->
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
            this.getSettingsData();
        },
        data() {
            return {
                content: [],
                settings: {
                    pagination_size: '',
                    currency: '',
                    priority_size: '',
                    invoice_tax: '',
                    stats: ''
                },
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

            storeSettingsData() {
                this.progressBar = true;

                let settings = {
                    pagination_size: this.settings.pagination_size,
                    currency: this.settings.currency,
                    priority_size: this.settings.priority_size,
                    invoice_tax: this.settings.invoice_tax,
                    stats: this.settings.stats,
                };

                this.progressBar = true;
                this.content = [];
                this.$axios
                    .post(`./api/settings/store`, settings)
                    .then((response) => {
                        this.getSettingsData();
                        this.success = this.handleSuccess(response.data.success.message);
                        this.progressBar = false;
                        router.push({name: 'clients'})
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

            getSettingsData() {
                this.progressBar = true;
                this.$axios
                    .get(`./api/settings/data`, [])
                    .then((response) => {
                        this.settings = response.data.configData;
                        this.content = response.data.systemLogs;
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
