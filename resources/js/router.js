import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
import Graph from '../components/Graph.vue'
import Login from '../template/Login.vue'
import Dashboard from '../components/Dashboard.vue'
import RegisteredAccounts from '../components/RegisteredAccounts.vue'
import RegisteredAlumnis from '../components/RegisteredAlumnis.vue'
import Account from '../components/Account.vue'
import UserList from '../components/UserList.vue'
import Forum from '../components/OpenForum.vue'
import Course from '../components/Course.vue'

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/graph',
            name: 'graph',
            component: Graph
        },
        {
            path: '/registeredaccounts',
            name: 'registeredaccounts',
            component: RegisteredAccounts
        },
        {
            path: '/course',
            name: 'course',
            component: Course
        },
        {
            path: '/forum',
            name: 'forum',
            component: Forum
        },
        {
            path: '/userlist',
            name: 'userlist',
            component: UserList
        },

        {
            path: '/account',
            name: 'account',
            component: Account
        },

        {
            path: '/login',
            name: 'login',
            component: Login
        },

        {
            path: '/',
            name: 'dashobard',
            component: Dashboard
        },

        {
            path: '/registeredalumnis',
            name: 'registeredalumnis',
            component: RegisteredAlumnis
        },
    ],
});
