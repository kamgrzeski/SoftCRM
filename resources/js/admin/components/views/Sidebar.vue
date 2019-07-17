<template>
    <v-content>
        <div id="wrapper">
            <nav class="navbar navbar-default top-navbar" role="navigation">
                <div class="navbar-header">
                    <router-link to="/dashboard" class="navbar-brand" style="text-decoration: none">
                        <i class="fa fa-comments"></i>SoftCRM
                    </router-link>
                </div>
                <ul class="nav navbar-right">
                    <li class="dropdown">
                        <router-link to="#" class="dropdown-toggle avatar" data-toggle="dropdown" aria-expanded="false">
                            <img src="images/avatar.png">
                            <span>Welcome admin</span><i class="fa fa-caret-down"></i>
                        </router-link>
                        <ul class="dropdown-menu">
                            <li>
                                <router-link to="/profile">
                                    <i class="fa fa-user fa-fw"></i>Admin Profile</router-link>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <router-link to="/logout">
                                    <i class="fa fa-sign-out fa-fw"></i>Logout</router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <div class="sidebar">
                <nav class="navbar-default navbar-side" role="navigation">
                    <div class="sidebar-collapse">
                        <ul class="nav" id="main-menu">
                            <li>
                                <router-link to="#"><i class="fa fa-dashboard"></i>System<span class="fa arrow"></span></router-link>
                                <ul class="nav">
                                    <li>
                                        <router-link to="/dashboard" class="router-link-selected">Dashboard</router-link>
                                        <router-link to="/settings" class="router-link-selected">Settings</router-link>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <router-link to="#"><i class="fa fa-user"></i>Dependencies<span class="fa arrow"></span></router-link>
                                <ul class="nav">
                                    <li v-if="content">
                                        <router-link to="/clients" class="router-link-selected">Clients
                                            <span class="label label-dependencies pull-right">
                                                {{ content.counts.countClients }}
                                            </span>
                                        </router-link>
                                        <router-link to="/employees" class="router-link-selected">Employees
                                            <span class="label label-dependencies pull-right">
                                                {{ content.counts.countEmployees }}
                                            </span>
                                        </router-link>
                                        <router-link to="/deals" class="router-link-selected">Deals
                                            <span class="label label-dependencies pull-right">
                                                {{ content.counts.countDeals }}
                                            </span>
                                        </router-link>
                                        <router-link to="/companies" class="router-link-selected">Companies
                                            <span class="label label-dependencies pull-right">
                                                {{ content.counts.countCompanies }}
                                            </span>
                                        </router-link>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <router-link to="#"><i class="fa fa-money"></i>Marketing<span class="fa arrow"></span></router-link>
                                <ul class="nav">
                                    <li v-if="content">
                                        <router-link to="/products" class="router-link-selected">Products
                                            <span class="label label-marketing pull-right">
                                                {{ content.counts.countProducts }}
                                            </span>
                                        </router-link>
                                        <router-link to="/tasks" class="router-link-selected">Tasks
                                            <span class="label label-marketing pull-right">
                                                {{ content.counts.countTasks }}
                                            </span>
                                        </router-link>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <router-link to="#">
                                    <i class="fa fa-shopping-cart"></i>Sales<span class="fa arrow"></span></router-link>
                                <ul class="nav">
                                    <li v-if="content">
                                        <router-link to="/finances" class="router-link-selected">Finances
                                            <span class="label label-sales pull-right">
                                                {{ content.counts.countFinances }}
                                            </span>
                                        </router-link>
                                        <router-link to="/sales" class="router-link-selected">Sales
                                            <span class="label label-sales pull-right">
                                                {{ content.counts.countSales }}
                                            </span>
                                        </router-link>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="infos" v-if="content">
                            <h4>Information</h4>
                            <li><i class="fa fa-money margin-fa" aria-hidden="true"></i> Today income:  {{ content.statistics.todayIncome }}</li>
                            <li><i class="fa fa-money margin-fa" aria-hidden="true"></i> Yesterday income: {{ content.statistics.yesterdayIncome }}</li>
                            <li><i class="fa fa-money margin-fa" aria-hidden="true"></i> Cash turnover: {{ content.statistics.cashTurnover }}</li>
                            <li><i class="fa fa-cogs margin-fa info-system" aria-hidden="true"></i> Operations: {{ content.statistics.countAllRowsInDb }}</li>
                            <li><i class="fa fa-book margin-fa" aria-hidden="true"></i> System logs: {{ content.statistics.countSystemLogs }}</li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

    </v-content>
</template>

<script>
    export default {
        name: 'Sidebar',
        data() {
            return {
            }
        },
        computed:{
            content() {
                return this.$store.state.contentData
            }

        },
        created() {
            this.$store.dispatch('getContentData')
        }
    }
</script>

<style>
    .info-system {
        margin-top: 30px;
    }
    .router-link-selected {
        background-color: #013156 !important;
    }
    .avatar img {
        margin-right: 13px;
    }
    .avatar span {
        margin-right: 20px;
    }
    .infos li {
        list-style-type: none;
    }
    .margin-fa {
        margin-right: 8px;
    }
    .pull-right {
        margin-top:4px
    }
    .infos {
        margin-top: 10px; 
        color: #dee7f1;
        font-size: 14px;
        margin-left: -13px;
    }
    
    .sidebar-collapse {
        width: 100%;
        height: 100% !important;
        background-color: #054a7f
    }
    .sidebar {
        height: 100% !important;
        background-color: #054a7f
    }
</style>
