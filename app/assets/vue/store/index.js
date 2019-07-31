import Vue from 'vue';
import Vuex from 'vuex';
import SecurityModule from './security';
import AddressesModule from './shippingAddress';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        security: SecurityModule,
        shippingAddress: AddressesModule,
    },
});