import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

import state from './state'
import * as mutations from './mutations'
import * as actions from './actions'
import * as getters from './getters' 

import user from '../components/User/UserStore'
//===========================================================================================================
//                                      Common Components
//===========================================================================================================



export default new Vuex.Store({
    state,
    getters,
    mutations,
    actions,
    modules : {
        user
    }
});