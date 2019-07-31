<template>
    <div>
        <div class="row col">
            <h1>Create new address</h1>
        </div>

        <div v-if="isLoading" class="row col mt-3 mb-3">
            <div class="spinner-grow text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div v-else-if="hasError" class="row col">
            <error-message :error="error"></error-message>
        </div>

        <div v-if="addresses.length < 3" class="row col">
            <form>
                <div class="form-row">
                    <div class="col-4">
                        <label>Country</label>
                    </div>
                    <div class="col-8">
                        <input v-model="country" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-4">
                        <label>City</label>
                    </div>
                    <div class="col-8">
                        <input v-model="city" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-4">
                        <label>Street</label>
                    </div>
                    <div class="col-8">
                        <input v-model="street" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-4">
                        <label>ZIP</label>
                    </div>
                    <div class="col-8">
                        <input v-model="zip" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-4">
                        <label>Is default</label>
                    </div>
                    <div class="col-8">
                        <input v-model="isDefault" type="checkbox">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12">
                        <button @click="addAddress()" :disabled="country.length === 0 || city.length === 0 || street.length === 0 || zip.length === 0 || isLoading" type="button" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>

        <div v-else-if="addresses.length >= 3" class="row col">
            You cannot add new addresses anymore.
        </div>

    </div>
</template>


<script>
    import ShippingAddress from '../components/ShippingAddress';
    import ErrorMessage from '../components/ErrorMessage';

    export default {
        name: 'address-add',
        components: {
            ShippingAddress,
            ErrorMessage,
        },
        data () {
            return {
                country: '',
                city: '',
                street: '',
                zip: '',
                isDefault: false
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
            addAddress () {
                this.$store.dispatch('shippingAddress/create', [
                    this.$data.country,
                    this.$data.city,
                    this.$data.street,
                    this.$data.zip,
                    this.$data.isDefault,
                ])
                .then(() => {
                    this.$data.country = '';
                    this.$data.city = '';
                    this.$data.street = '';
                    this.$data.zip = '';
                    this.$data.isDefault = false;
                    this.$router.push({path: '/addresses'})
                })
            },
        },
    }
</script>

