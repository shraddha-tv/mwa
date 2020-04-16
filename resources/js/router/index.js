
import Vue from 'vue'
import Router from 'vue-router'

//===========================================================================================================
//                                      Common Components
//===========================================================================================================

import DashBoard from '../components/DashBoard'
import Users from '../components/User'
import Goods from '../components/Goods'
import State from '../components/AdminBoard/State'
import Category from '../components/AdminBoard/GoodsCategory'
import GoodsName from '../components/AdminBoard/GoodsName'



Vue.use(Router)

const mainRoutes = [
    { path: '/', component: DashBoard },
    { path: '/users', component: Users },
    { path: '/goods', component: Goods },
    { path: '/state', component: State },
    { path: '/goods_category', component: Category },
    { path: '/goods_name', component: GoodsName },

]

export default new Router({
    // mode: 'history',
    routes: mainRoutes
})