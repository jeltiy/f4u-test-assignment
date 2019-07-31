<template>
    <div class="card w-100 mt-2">
        <div class="card-body">
            <strong>Country</strong>: {{ message }}<br>
            <strong>City</strong>: {{ city }}<br>
            <strong>Street</strong>: {{ street }}<br>
            <strong>Zip</strong>: {{ zip }}<br>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'shippingAddress',
        props: [
            'country',
            'city',
            'street',
            'zip'
        ],
    }
</script>