import Vue from 'vue'
import Router from 'vue-router'
import Base from './components/Base.vue';
import Dashboard from './components/views/Dashboard.vue';
import Settings from './components/views/Settings/Settings.vue';

//admin
import AdminLogin from './components/views/Authentication/AdminLogin.vue';
import AdminLogout from './components/views/Authentication/AdminLogout.vue';
import AdminProfile from './components/views/Authentication/AdminProfile.vue';

//clients
import ClientsList from './components/views/Clients/ClientsList.vue';
import ClientsStore from './components/views/Clients/ClientsStore.vue';
import ClientsEdit from './components/views/Clients/ClientsEdit.vue';
import ClientsView from './components/views/Clients/ClientsView.vue';

//employees
import EmployeesList from './components/views/Employees/EmployeesList.vue';
import EmployeesStore from './components/views/Employees/EmployeesStore.vue';
import EmployeesEdit from './components/views/Employees/EmployeesEdit.vue';
import EmployeesView from './components/views/Employees/EmployeesView.vue';

//deals
import DealsList from './components/views/Deals/DealsList.vue';
import DealsStore from './components/views/Deals/DealsStore.vue';
import DealsEdit from './components/views/Deals/DealsEdit.vue';
import DealsView from './components/views/Deals/DealsView.vue';

import CompaniesList from './components/views/Companies/CompaniesList.vue';
import ProductsList from './components/views/Products/ProductsList.vue';
import TasksList from './components/views/Tasks/TasksList.vue';
import FinancesList from './components/views/Finances/FinancesList.vue';
import SalesList from './components/views/Sales/SalesList.vue';

Vue.use(Router);

const routes = [
    {
        path: '/login',
        name: 'login',
        component: AdminLogin
    },
    {
        path: '/logout',
        name: 'logout',
        component: AdminLogout
    },
    {
        path: '/',
        component: Base,
        redirect: '/login',
        children: [
            {
                name: 'profile',
                path: 'profile',
                component: AdminProfile,
            },
            {
                name: 'dashboard',
                path: 'dashboard',
                component: Dashboard,
            },
            {
                name: 'settings',
                path: 'settings',
                component: Settings,
            },
            
            // clients
            {
                name: 'clients',
                path: 'clients',
                component: ClientsList,
            },
            {
                name: 'clients/add',
                path: 'clients/add',
                component: ClientsStore,
            },
            {
                name: 'clients/view',
                path: 'clients/view/:id',
                component: ClientsView,
            },
            {
                name: 'clients/edit',
                path: 'clients/edit/:id',
                component: ClientsEdit,
            },
            
            //employees
            {
                name: 'employees',
                path: 'employees',
                component: EmployeesList,
            },
            {
                name: 'employees/add',
                path: 'employees/add',
                component: EmployeesStore,
            },
            {
                name: 'employees/view',
                path: 'employees/view/:id',
                component: EmployeesView,
            },
            {
                name: 'employees/edit',
                path: 'employees/edit/:id',
                component: EmployeesEdit,
            },
            
            //deals
            {
                name: 'deals',
                path: 'deals',
                component: DealsList,
            },
            {
                name: 'deals/add',
                path: 'deals/add',
                component: DealsStore,
            },
            {
                name: 'deals/view',
                path: 'deals/view/:id',
                component: DealsView,
            },
            {
                name: 'deals/edit',
                path: 'deals/edit/:id',
                component: DealsEdit,
            },
            
            //companies
            {
                name: 'companies',
                path: 'companies',
                component: CompaniesList,
            },
            {
                name: 'products',
                path: 'products',
                component: ProductsList,
            },
            {
                name: 'tasks',
                path: 'tasks',
                component: TasksList,
            },
            {
                name: 'finances',
                path: 'finances',
                component: FinancesList,
            },
            {
                name: 'sales',
                path: 'sales',
                component: SalesList,
            },
        ]
    },

];

const router = new Router({
    routes: routes // short for `routes: routes`
});

export default router;
