import AddressesAPI from '../api/shippingAddress';

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        addresses: [],
        defaultIndex: -1
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
        hasAddresses (state) {
            return state.addresses.length > 0;
        },
        addresses (state) {
            return state.addresses;
        },
        getDefault (state) {
            return state.defaultIndex;
        },
    },
    mutations: {
        ['UPDATE_ADDRESS_START'](state) {
            state.isLoading = true;
            state.error = null;
        },
        ['UPDATING_ADDRESS_SUCCESS'](state, data) {
            state.isLoading = false;
            state.error = null;
            let id = data[0];
            let address = data[1];

            // TODO: refactor mutations
            // if update an exiting address
            if(id == -2 || id >= 0) {
                if(address.isDefault == true) {
                    state.addresses[state.defaultIndex].isDefault = false;
                }
                const currentIndex = state.addresses.findIndex(p => p.id === id);
                state.addresses.splice(currentIndex, 1, address);
                state.defaultIndex = state.addresses.findIndex(p => p.isDefault == true);
            } else
            if(id == -2) {
                // delete
                const currentIndex = state.addresses.findIndex(p => p.id === id);
                state.addresses.splice(currentIndex, 1);
                state.defaultIndex = state.addresses.findIndex(p => p.isDefault == true);
            } else {
                // add
                state.addresses.unshift(address);
            }
        },
        ['UPDATING_ADDRESS_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error;
            state.addresses = [];
            state.defaultIndex = -1;
        },
        ['FETCHING_ALL'](state) {
            state.isLoading = true;
            state.error = null;
            state.addresses = [];
            state.defaultIndex = -1;
        },
        ['FETCHING_ALL_SUCCESS'](state, addresses) {
            state.isLoading = false;
            state.error = null;
            state.addresses = addresses;
            state.defaultIndex = state.addresses.findIndex(p => p.isDefault == true);
        },
        ['FETCHING_ALL_ERROR'](state, error) {
            state.isLoading = false;
            state.error = error;
            state.addresses = [];
            state.defaultIndex = -1;
        },
    },
    actions: {
        create ({commit}, data) {
            commit('UPDATE_ADDRESS_START');
            return AddressesAPI.create(data)
                .then(res => commit('UPDATING_ADDRESS_SUCCESS', [-1, res.data]))
                .catch(err => commit('UPDATING_ADDRESS_ERROR', err));
        },
        edit ({commit}, data) {
            commit('UPDATE_ADDRESS_START');
            let id = data[0];
            return AddressesAPI.edit(data)
                .then(res => commit('UPDATING_ADDRESS_SUCCESS', [id, res.data]))
                .catch(err => commit('UPDATING_ADDRESS_ERROR', err));
        },
        getAll ({commit}) {
            commit('FETCHING_ALL');
            return AddressesAPI.getAll()
                .then(res => commit('FETCHING_ALL_SUCCESS', res.data))
                .catch(err => commit('FETCHING_ALL_ERROR', err));
        },
        makeDefault ({commit}, id) {
            commit('UPDATE_ADDRESS_START');
            return AddressesAPI.makeDefault(id)
                .then(res => commit('UPDATING_ADDRESS_SUCCESS', [id, res.data]))
                .catch(err => commit('UPDATING_ADDRESS_ERROR', err));
        },
        delete ({commit}, id) {
            commit('UPDATE_ADDRESS_START');
            return AddressesAPI.delete(id)
                .then(res => commit('UPDATING_ADDRESS_SUCCESS', [-2, res.data]))
                .catch(err => commit('UPDATING_ADDRESS_ERROR', err));
        },
    },
}