// **********************************************************************************************************
//                           Set Dialog Value for Form Toggle
// **********************************************************************************************************
export const set_dialog_form = ({ commit }) => {
    commit('set_dialog_form')
}

// **********************************************************************************************************
//                           Set Dialog Value for Form Toggle
// **********************************************************************************************************
export const set_edit_item = ({ commit },item) => {
    commit('set_edit_item',item)
}

// **********************************************************************************************************
//                           Get all users in database with Pagination
// **********************************************************************************************************
export const get_items = ({ commit }, page) => {
    return new Promise((resolve, reject) => {
        axios.get(`api/goods?page=${page}`).then(response => {
            // Response data store the state array through mutation
            commit('set_all_items', response.data)
            resolve(response.data);
        }, error => {
            reject(error);
        })
    })
}

// **********************************************************************************************************
//                           Add New Bank to the database
// **********************************************************************************************************
export const add_new_item = ({ commit, dispatch }, item) => {
    return new Promise((resolve, reject) => {
        axios.post('api/goods', item).then(response => {
            // Show Success Massage After Created Bank
            dispatch('set_message', { message: response.data.message, type: 'success' }, { root: true })
            resolve(response);
        }, error => {
            // Show Error Massage, When Faild to Create Bank
            dispatch('set_message', { message: error.response.data, type: 'error' }, { root: true })
            reject(error);
        })
    })
}

// **********************************************************************************************************
//                           Update existing Bank in Database
// **********************************************************************************************************
export const update_item = ({ commit, dispatch }, item) => {
    return new Promise((resolve, reject) => {
        axios.put(`api/goods/${item.id}`, item).then(response => {
            // Show Success Massage After Updated Bank
            dispatch('set_message', { message: response.data.message, type: 'success' }, { root: true })
            resolve(response);
        }, error => {
            // Show Error Massage, When Faild to Update Bank
            dispatch('set_message', { message: error.response.data, type: 'error' }, { root: true })
            reject(error);
        })
    })
}

// **********************************************************************************************************
//                           Delete Given Bank in the Database
// **********************************************************************************************************
export const delete_item = ({ dispatch }, id) => {
    return new Promise((resolve, reject) => {
        axios.delete(`api/goods/${id}`).then(response => {
            // Get All Updated users in Database
            dispatch('get_items')
            // Show Success Massage After Deleted Bank
            dispatch('set_message', { message: "Bank Deleted Successfully", type: 'success' }, { root: true })
            resolve(response);
        }, error => {
            // Show Error Massage, When Faild to Delete Bank
            dispatch('set_message', { message: error.response.statusText, type: 'error' }, { root: true })
            reject(error);
        })
    })
}

// **********************************************************************************************************
//                           Delete Given Bank in the Database
// **********************************************************************************************************
export const get_asserts = ({ dispatch, commit }) => {
    return new Promise((resolve, reject) => {
        axios.get('api/goods/asserts').then(response => {
            commit('set_asserts', response.data)
            resolve(response);
        }, error => {
            // Show Error Massage, When Faild to Delete Bank
            dispatch('set_message', { message: error.response.statusText, type: 'error' }, { root: true })
            reject(error);
        })
    })
}

// **********************************************************************************************************
//                           Delete Given Bank in the Database
// **********************************************************************************************************
export const item_search = ({ dispatch, commit },query) => {
    return new Promise((resolve, reject) => {
        axios.get('api/public/search',{
            params: { searchquery: query }
        }).then(response => {
            commit('set_all_items', response.data)
            resolve(response);
        }, error => {
            // Show Error Massage, When Faild to Delete Bank
            dispatch('set_message', { message: error.response.statusText, type: 'error' }, { root: true })
            reject(error);
        })
    })
}

// **********************************************************************************************************
//                           Delete Given Bank in the Database
// **********************************************************************************************************
export const item_advanced_search = ({ dispatch, commit },item) => {
    return new Promise((resolve, reject) => {
        axios.post('api/public/search',item).then(response => {
            commit('set_all_items', response.data)
            resolve(response);
        }, error => {
            // Show Error Massage, When Faild to Delete Bank
            dispatch('set_message', { message: error.response.statusText, type: 'error' }, { root: true })
            reject(error);
        })
    })
}

// **********************************************************************************************************
//                           Delete Given Bank in the Database
// **********************************************************************************************************
export const get_goods_profile = ({ dispatch, commit },id) => {
    return new Promise((resolve, reject) => {
        axios.get(`api/public/goods/${id}`).then(response => {
            commit('set_active_goods', response.data)
            resolve(response);
        }, error => {
            // Show Error Massage, When Faild to Delete Bank
            dispatch('set_message', { message: error.response.statusText, type: 'error' }, { root: true })
            reject(error);
        })
    })
}