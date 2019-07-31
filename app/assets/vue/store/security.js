import SecurityAPI from '../api/security';

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        isAuthenticated: false,
        firstName: null,
        lastName: null,
    },
    getters: {
        isLoading (state) {
            return state.isLoading;
        },
        hasError (state) {
            return state.error !== null;
        },
        error (state) {
            return state.error;
        },
        firstName (state) {
            return state.firstName;
        },
        lastName (state) {
            return state.lastName;
        },
        isAuthenticated (state) {
            return state.isAuthenticated;
        },
    },
    mutations: {
        ['AUTHENTICATING'](state) {
            state.isLoading = true;
            state.error = null;
            state.isAuthenticated = false;
        },
        ['PROFILE_LOAD'](state, data) {
            state.firstName = data[0];
            state.lastName = data[1];
        },
        ['UPDATE_START'](state) {
            state.isLoading = true;
            state.error = null;
        },
        ['UPDATE_SUCCESS'](state, data) {
            state.firstName = data.firstName;
            state.lastName = data.lastName;
            state.isLoading = false;
        },
        ['UPDATE_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error;
        },
        ['SET_FIRST_NAME'](state, firstName) {
            state.firstName = firstName;
        },
        ['SET_LAST_NAME'](state, lastName) {
            state.lastName = lastName;
        },
    },
    actions: {
        load ({commit}, data) {
            commit('PROFILE_LOAD', data);
            return;
        },
        setFirstName: ({commit, state}, firstName) => {
            commit('SET_FIRST_NAME', firstName)
            return state.firstName;
        },
        setLastName: ({commit, state}, lastName) => {
            commit('SET_LAST_NAME', lastName)
            return state.lastName;
        },
        edit ({commit}, data) {
            commit('UPDATE_START');
            return SecurityAPI.edit(data)
                .then(res => commit('UPDATE_SUCCESS', res.data))
                .catch(err => commit('UPDATE_ERROR', err));
        },
    },
}