<template>
    <v-content>
        <div id="wrapper">
            <div id="page-wrapper">
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <v-progress-linear :indeterminate="progressBar" v-if="progressBar"></v-progress-linear>
                            <h1 class="page-header">
                                <small>Deals list</small>
                                <v-btn
                                        v-on:click="goToDealStoreTemplate()"
                                        color="green"
                                        class="white--text store-button"
                                        :disabled="progressBar"
                                        :loading="progressBar"
                                >
                                    Add new deal
                                    <v-icon right dark>cloud_upload</v-icon>
                                </v-btn>
                            </h1>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center-header">#</th>
                                    <th class="text-center-header">Name</th>
                                    <th class="text-center-header">start time</th>
                                    <th class="text-center-header">end time</th>
                                    <th class="text-center-header">Company Id</th>
                                    <th class="text-center-header">Status</th>
                                    <th class="text-center-header" style="width:200px">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="odd gradeX" v-for="(item, index) in content">
                                    <td class="text-center">{{ index + 1 }}</td>
                                    <td class="text-center">{{ item.name }}</td>
                                    <td class="text-center">{{ item.start_time }}</td>
                                    <td class="text-center">{{ item.end_time }}</td>
                                    <td class="text-center">{{ item.companies_id }}</td>
                                    <td class="text-center">
                                        <toggle-button :value="item.is_active === 1 ? true : false"
                                                       color="#D84315"
                                                       :sync="true"
                                                       :width="110"
                                                       :height="30"
                                                       :font-size="15"
                                                       :labels="{checked: 'Active', unchecked: 'Deactive'}"
                                                       class="toggle-button"
                                                       @change="disableDeal(item.id, item.is_active)"/>
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
                                                        <router-link :to="{ name: 'deals/view', params: { id: item.id }}" class="blue--text">View</router-link>
                                                    </v-list-tile>
                                                    <v-list-tile>
                                                        <router-link :to="{ name: 'deals/edit', params: { id: item.id }}" class="green--text">Edit</router-link>
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
                content: [],
                warning: '',
                success: '',
                progressBar: true,
            }
        },
        props: [],
        computed: {},
        methods: {
            goToDealStoreTemplate() {
              return this.$router.push('deals/add');
            },
            handleError(warning) {
                this.$toast.error(warning, 'Error');
            },
            handleSuccess(success) {
                this.$toast.success(success, 'OK');
            },
            disableDeal(dealId, type) {
                this.progressBar = true;
                this.$axios
                    .put(`./api/deals/set-active`, {dealId: dealId, type: type})
                    .then((response) => {
                        this.success = this.handleSuccess(response.data.success.message);
                        this.progressBar = false;
                        this.getDealsData();
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
                    .get(`./api/deals/list`, [])
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
