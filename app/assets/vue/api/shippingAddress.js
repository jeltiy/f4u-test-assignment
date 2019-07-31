import axios from 'axios';

export default {
    makeDefault (id) {
        return axios.post('/api/shipping_addresses/' + id + '/make_default');
    },
    create (address) {
        return axios.post(
            '/api/shipping_addresses/create',
            {
                country: address[0],
                city: address[1],
                street: address[2],
                zip: address[3],
                is_default: address[4],
            }
        );
    },
    edit (address) {
        let id = address[0];
        return axios.post(
            '/api/shipping_addresses/' + id + '/update',
            {
                country: address[1],
                city: address[2],
                street: address[3],
                zip: address[4],
                is_default: address[5],
            }
        );
    },
    delete (id) {
        return axios.post('/api/shipping_addresses/' + id + '/delete');
    },
    getAll () {
        return axios.get('/api/shipping_addresses');
    },
}