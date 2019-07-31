<template>
    <div>
        <h1>Profile</h1>

        <div v-if="isLoading" class="row col mt-3 mb-3">
            <div class="spinner-grow text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <div v-else-if="hasError" class="row col">
            <error-message :error="error"></error-message>
        </div>

        <div class="row col mb-3">
            <form>
                <div class="form-row">
                    <div class="col-4">
                        <label>First name</label>
                    </div>
                    <div class="col-8">
                        <input v-model="firstName" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-4">
                        <label>Last name</label>
                    </div>
                    <div class="col-8">
                        <input v-model="lastName" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-12">
                        <button @click="updateProfile()" :disabled="firstName.length === 0 || lastName.length === 0 || isLoading" type="button" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</template>

<script>
    import ErrorMessage from '../components/ErrorMessage';

    export default {
        name: 'profile',
        components: {
            ErrorMessage,
        },
        created () {

        },
        computed: {
            isLoading () {
                return this.$store.getters['security/isLoading'];
            },
            hasError () {
                return this.$store.getters['security/hasError'];
            },
            error () {
                return this.$store.getters['security/error'];
            },
            firstName: {
                get () {
                    return this.$store.getters['security/firstName'];
                },
                set (firstName) {
                    return this.$store.dispatch('security/setFirstName', firstName);
                }
            },
            lastName: {
                get () {
                    return this.$store.getters['security/lastName'];
                },
                set (lastName) {
                    return this.$store.dispatch('security/setLastName', lastName);
                }
            },
            isAuthenticated () {
                return this.$store.getters['security/isAuthenticated'];
            },
        },
        methods: {
            updateProfile () {
                this.$store.dispatch('security/edit', [
                    this.firstName,
                    this.lastName,
                ]);
            },
        },
    }
</script>