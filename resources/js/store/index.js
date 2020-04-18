import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

import state from './state'
import * as mutations from './mutations'
import * as actions from './actions'
import * as getters from './getters' 

import user from '../components/User/UserStore'
import goods from '../components/Goods/GoodsStore'
import states from '../components/AdminBoard/State/StateStore'
import category from '../components/AdminBoard/GoodsCategory/CategoryStore'
import goods_name from '../components/AdminBoard/GoodsName/GoodsNameStore'
//===========================================================================================================
//                                      Common Components
//===========================================================================================================



export default new Vuex.Store({
    state,
    getters,
    mutations,
    actions,
    modules : {
        user,
        goods,
        states,
        category,
        goods_name
    }
});