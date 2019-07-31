<template>
    <div>
        <div class="row col">
            <h1>Shipping addresses</h1>
        </div>

        <div v-if="isLoading" class="row col mt-3 mb-3">
            <div class="spinner-grow text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div v-else-if="hasError" class="row col">
            <error-message :error="error"></error-message>
        </div>

        <div v-if="!hasAddresses" class="row col">
            <p>No addresses added</p>
        </div>

        <div v-else-if="editItem >= 0" class="row col mb-3">
            <form>
                <div class="form-row">
                    <div class="col-4">
                        <label>Country</label>
                    </div>
                    <div class="col-8">
                        <input v-model="addresses[editItem].country" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-4">
                        <label>City</label>
                    </div>
                    <div class="col-8">
                        <input v-model="addresses[editItem].city" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-4">
                        <label>Street</label>
                    </div>
                    <div class="col-8">
                        <input v-model="addresses[editItem].street" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-4">
                        <label>ZIP</label>
                    </div>
                    <div class="col-8">
                        <input v-model="addresses[editItem].zip" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-4">
                        <label>Is default</label>
                    </div>
                    <div class="col-8">
                        <input v-model="addresses[editItem].isDefault" type="checkbox">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12">
                        <button @click="updateAddress(editItem)" :disabled="addresses[editItem].country.length === 0 || addresses[editItem].city.length === 0 || addresses[editItem].street.length === 0 || addresses[editItem].zip.length === 0 || isLoading" type="button" class="btn btn-primary">Submit</button>
                        <button @click="editItem = -1" type="button" :disabled="isLoading" class="btn btn-default">Cancel</button>
                    </div>
                </div>
            </form>
        </div>

        <table v-else class="table table-striped table-hover mt-3">
            <tr>
                <th>ID</th>
                <th>Country</th>
                <th>City</th>
                <th>Street</th>
                <th>Zip</th>
                <th>Actions</th>
            </tr>
            <tr v-for="(addr, index) in addresses" :class="{ 'font-weight-bold' : getDefault == index }">
                <td>{{ addr.id }}</td>
                <td>{{ addr.country }}</td>
                <td>{{ addr.city }}</td>
                <td>{{ addr.street }}</td>
                <td>{{ addr.zip }}</td>
                <td>
                    <button :disabled="isLoading" type="button" class="btn btn-primary" @click="edit(index)">Edit</button>
                    <button :disabled="isLoading" v-if="getDefault != index" type="button" class="btn btn-success" @click="makeDefault(addr.id)">Make default</button>
                    <button :disabled="isLoading" type="button" class="btn btn-danger" @click="deleteAddress(addr.id)">Delete</button>
                </td>
            </tr>
        </table>

        <router-link class="btn btn-primary" tag="a" to="/addresses/create">
            Create new address
        </router-link>

    </div>
</template>

<script>
    import ShippingAddress from '../components/ShippingAddress';
    import ErrorMessage from '../components/ErrorMessage';

    export default {
        name: 'address-list',
        components: {
            ShippingAddress,
            ErrorMessage,
        },
        data () {
            return {
                editItem: -1
            };
        },
        created () {
            if(!this.hasAddresses) {
                this.$store.dispatch('shippingAddress/getAll');
            }
        },
        computed: {
            isLoading () {
                return this.$store.getters['shippingAddress/isLoading'];
            },
            hasError () {
                return this.$store.getters['shippingAddress/hasError'];
            },
            error () {
                return this.$store.getters['shippingAddress/error'];
            },
            hasAddresses () {
                return this.$store.getters['shippingAddress/hasAddresses'];
            },
            addresses () {
                return this.$store.getters['shippingAddress/addresses'];
            },
            getDefault () {
                return this.$store.getters['shippingAddress/getDefault'];
            },
        },
        methods: {
            updateAddress () {
                this.$store.dispatch('shippingAddress/edit', [
                    this.addresses[this.editItem].id,
                    this.addresses[this.editItem].country,
                    this.addresses[this.editItem].city,
                    this.addresses[this.editItem].street,
                    this.addresses[this.editItem].zip,
                    this.addresses[this.editItem].isDefault,
                ]).then(() => {
                    this.editItem = -1;
                })
            },
            edit (address_id) {
                this.editItem = address_id;
            },
            makeDefault (address_id) {
                this.$store.dispatch('shippingAddress/makeDefault', address_id);
            },
            deleteAddress (address_id) {
                this.$store.dispatch('shippingAddress/delete', address_id);
            },
        },
    }
</script>