
import Vue from 'vue'
import Router from 'vue-router'

//===========================================================================================================
//                                      Common Components
//===========================================================================================================

import DashBoard from '../components/DashBoard'
import Users from '../components/User'



Vue.use(Router)

const mainRoutes = [
    { path: '/', component: DashBoard },
    { path: '/users', component: Users },

]

export default new Router({
    // mode: 'history',
    routes: mainRoutes
})