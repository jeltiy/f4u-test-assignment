import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '../store';
import Home from '../views/Home';
import Profile from '../views/Profile';
import Addresses from '../views/AddressList';
import AddressNew from '../views/AddressNew';

Vue.use(VueRouter);

let router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/home', component: Home },
        { path: '/profile', component: Profile },
        { path: '/addresses', component: Addresses },
        { path: '/addresses/create', component: AddressNew },
        { path: '*', redirect: '/home' }
    ],
});

export default router;