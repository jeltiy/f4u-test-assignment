<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <router-link class="navbar-brand" to="/home">App</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <router-link class="nav-item" tag="li" to="/home" active-class="active">
                        <a class="nav-link">Home</a>
                    </router-link>
                    <router-link class="nav-item" tag="li" to="/profile" active-class="active">
                        <a class="nav-link">My profile</a>
                    </router-link>
                    <router-link class="nav-item" tag="li" to="/addresses" active-class="active">
                        <a class="nav-link">My addresses</a>
                    </router-link>
                </ul>
            </div>
        </nav>

        <router-view></router-view>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'app',
        created () {
            let firstName = this.$parent.$el.attributes['data-first-name'].value,
                lastName = this.$parent.$el.attributes['data-last-name'].value;

            this.$store.dispatch('security/load', [firstName, lastName]);
        },
    }
</script>