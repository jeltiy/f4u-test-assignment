import axios from 'axios';

export default {
    edit (data) {
        return axios.post(
            '/api/security/updateProfile',
            {
                first_name: data[0],
                last_name: data[1]
            }
        );
    },
}