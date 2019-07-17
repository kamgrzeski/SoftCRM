<template>
    <v-content>
        <div id="wrapper">
            <div id="page-wrapper">
                <div id="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="page-header">
                                <small class="title">Welcome in SoftCRM</small>
                            </h1>
                        </div>
                    </div>
                    <div class="row details">
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <router-link to="clients" style="text-decoration: none">
                                <div class="panel panel-primary no-boder bg-color-green">
                                    <div class="panel-body box-client">
                                        <i class="fa fa-female fa-3x"></i>
                                        <h3>Clients: {{ dashboard.counts.countClients }}
                                            (Excluded: {{ dashboard.counts.deactivatedClients }})
                                        </h3>
                                    </div>
                                    <div class="panel-footer back-footer-green boxes-font">
                                        {{ dashboard.counts.clientsInLatestMonth }} Increase in 30 Days
                                    </div>
                                </div>
                            </router-link>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="panel panel-primary no-boder bg-color-blue">
                                <router-link to="companies" v-if="dashboard" style="text-decoration: none">
                                    <div class="panel-body box-companies">
                                        <i class="fa fa-compass fa-3x"></i>
                                        <h3 v-if="dashboard">Companies: {{ dashboard.counts.countCompanies }}
                                            (Excluded: {{ dashboard.counts.deactivatedCompanies }})
                                        </h3>
                                    </div>
                                    <div class="panel-footer back-footer-blue boxes-font">
                                        {{ dashboard.counts.companiesInLatestMonth }} Increase in 30 Days
                                    </div>
                                </router-link>
                            </div>
                        </div>
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                <div class="panel panel-primary no-boder bg-color-red">
                                    <router-link to="employees" style="text-decoration: none">
                                        <div class="panel-body box-employees">
                                            <i class="fa fa fa-users fa-3x"></i>
                                            <h3 v-if="dashboard">Employees: {{ dashboard.counts.countEmployees }}
                                                (Excluded: {{ dashboard.counts.deactivatedEmployees }})
                                            </h3>
                                        </div>
                                        <div class="panel-footer back-footer-red boxes-font" v-if="dashboard">
                                            {{ dashboard.counts.employeesInLatestMonth }} Increase in 30 Days
                                        </div>
                                    </router-link>
                                </div>
                            </div>
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <div class="panel panel-primary no-boder bg-color-brown">
                                        <router-link to="deals" style="text-decoration: none">
                                        <div class="panel-body box-deals">
                                            <i class="fa fa-paperclip fa-3x"></i>
                                            <h3 v-if="dashboard">Deals: {{ dashboard.counts.countDeals }}
                                                ({{ dashboard.counts.deactivatedDeals }})
                                            </h3>
                                        </div>
                                            <div class="panel-footer back-footer-brown boxes-font" v-if="dashboard">
                                                {{ dashboard.counts.dealsInLatestMonth }} Increase in 30 Days
                                            </div>
                                        </router-link>
                                    </div>
                                </div>
                            </div>
                        <!--<TasksCharts></TasksCharts>-->
                            <div class="row details">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">Latest tasks
                                            <span class="badge red darken-4" v-if="dashboard">
                                                {{ dashboard.counts.countTasks }}
                                            </span>
                                            <span style="float: right" v-if="dashboard">
                                                Completed: {{ dashboard.data.completedTasks }} | Uncompleted: {{ dashboard.data.uncompletedTasks }}
                                            </span>
                                        </div>
                                        <div class="panel-body">
                                            <div class="list-group" v-for="item in dashboard.data.dataWithAllTasks">
                                                <a href="#" class="list-group-item">
                                                    <span class="badge badge">{{ item.created_at }}</span>
                                                    <span class="badge badge deep-orange">Duration: {{ item.duration }} days</span>
                                                    <i class="fa fa-fw fa-comment"></i> {{ item.name }}
                                                </a>
                                            </div>
                                            <div class="text-right">
                                                <router-link to="tasks">More Tasks <i
                                                        class="fa fa-arrow-circle-right"></i></router-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Latest companies <span class="badge red darken-4" v-if="dashboard">{{ dashboard.counts.countCompanies }}</span>
                                        </div>
                                        <div class="panel-body">
                                            <div class="list-group" v-for="item in dashboard.data.dataWithAllCompanies">
                                                <a href="#" class="list-group-item">
                                                    <i class="fa fa-compass"></i> {{ item.name }}
                                                    <span class="badge badge badge-phone teal accent-4" v-if="dashboard">Phone: {{ item.phone }}</span>
                                                </a>
                                            </div>
                                            <div class="text-right">
                                                <router-link to="/companies">More companies <i
                                                        class="fa fa-arrow-circle-right"></i></router-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Latest products <span class="badge red darken-4" v-if="dashboard">{{ dashboard.counts.countProducts }}</span>
                                        </div>
                                        <div class="panel-body">
                                            <div class="list-group" v-for="item in dashboard.data.dataWithAllProducts">
                                                <a href="#" class="list-group-item">
                                                    <span class="badge badge amber darken-2">{{ item.created_at }}</span>
                                                    <span class="badge badge brown darken-1">{{ item.count }} qty</span>
                                                    <span class="badge badge deep-orange">{{ item.price }}</span>
                                                    <i class="fa fa-fw fa-print"></i>{{ item.name }}
                                                </a>
                                            </div>
                                            <div class="text-right">
                                                <router-link to="products">More products <i class="fa fa-arrow-circle-right"></i></router-link>
                                            </div>
                                        </div>
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
    import Footer from "./../views/Footer";
    import TasksCharts from "./../views/Charts/TasksCharts.vue";
    import ProductsCharts from "./../views/Charts/ProductsCharts.vue";

    export default {
        components: {
            Footer,
            TasksCharts,
            ProductsCharts
        },
        created() {
        },
        data() {
            return {
                content: []
            }
        },
        props: [],
        computed: {
            dashboard() {
                return this.$store.state.contentData;
            }
        },
        methods: {}
    }
</script>

<style>
    .details {
        margin-top: 10px;
    }
    .badge-phone {
        background-color: #ff9800 !important;
    }

    .box-client {
        padding: 8px !important;
        border: 2px solid#38ab3d;
    }
    .box-client i {
        margin-bottom: 10px;
        font-size: 35px;
    }
    .box-client h3 {
        margin-bottom: 2px;
        font-size: 19px;
    }

    .box-companies {
        padding: 8px !important;
        border: 2px solid#00B0FF;
        color: #00B0FF;
    }
    .box-companies i {
        margin-bottom: 10px;
        font-size: 35px;
    }
    .box-companies h3 {
        margin-bottom: 2px;
        font-size: 19px;
    }

    .box-employees {
        padding: 8px !important;
        border: 2px solid#F4511E;
        color: #F4511E;
    }
    .box-employees i {
        margin-bottom: 10px;
        font-size: 35px;
    }
    .box-employees h3 {
        margin-bottom: 2px;
        font-size: 19px;
    }

    .box-deals {
        padding: 8px !important;
        border: 2px solid#FF9100;
        color: #FF9100;
    }
    .box-deals i {
        margin-bottom: 10px;
        font-size: 35px;
    }
    .box-deals h3 {
        margin-bottom: 2px;
        font-size: 19px;
    }

    .panel-primary {
        text-align: center;
    }

    .page-header small {
        color: black
    }
</style>