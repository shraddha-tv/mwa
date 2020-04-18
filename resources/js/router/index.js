
import Vue from 'vue'
import Router from 'vue-router'

//===========================================================================================================
//                                      Common Components
//===========================================================================================================

import DashBoard from '../components/DashBoard'
import Users from '../components/User'
import UserProfile from '../components/User/Profile'
import Farmers from '../components/User/FarmerTable.vue'
import Goods from '../components/Goods'
import GoodsProfile from '../components/Goods/Profile'
import State from '../components/AdminBoard/State'
import Category from '../components/AdminBoard/GoodsCategory'
import GoodsName from '../components/AdminBoard/GoodsName'



Vue.use(Router)

const mainRoutes = [
    { path: '/', component: DashBoard },
    { path: '/users', component: Users },
    { path: '/users/:id', component: UserProfile },
    { path: '/farmers', component: Farmers},
    { path: '/goods', component: Goods },
    { path: '/goods/:id', component: GoodsProfile },
    { path: '/state', component: State },
    { path: '/goods_category', component: Category },
    { path: '/goods_name', component: GoodsName },

]

export default new Router({
    // mode: 'history',
    routes: mainRoutes
})