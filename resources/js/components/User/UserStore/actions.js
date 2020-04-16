// **********************************************************************************************************
//                           Set Dialog Value for Form Toggle
// **********************************************************************************************************
export const set_toggle_form = ({ commit }) => {
    commit('set_toggle_form')
}

// **********************************************************************************************************
//                           Get all users in database with Pagination
// **********************************************************************************************************
export const get_users = ({ commit }, page) => {
    return new Promise((resolve, reject) => {
        axios.get(`api/users?page=${page}`).then(response => {
            // Response data store the state array through mutation
            commit('set_all_users', response.data)
            resolve(response.data);
        }, error => {
            reject(error);
        })
    })
}

// **********************************************************************************************************
//                           Add New Bank to the database
// **********************************************************************************************************
export const add_new_bank = ({ commit, dispatch }, item) => {
    return new Promise((resolve, reject) => {
        axios.post('api/users', item).then(response => {
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
export const update_bank = ({ commit, dispatch }, item) => {
    return new Promise((resolve, reject) => {
        axios.put(`api/users/${item.id}`, item).then(response => {
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
export const delete_bank = ({ dispatch }, id) => {
    return new Promise((resolve, reject) => {
        axios.delete(`api/users/${id}`).then(response => {
            // Get All Updated users in Database
            dispatch('get_users')
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