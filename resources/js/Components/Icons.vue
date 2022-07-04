<template>
    <svg v-if="name === 'cart'" aria-hidden="true" data-prefix="fas" data-icon="shopping-cart" class="svg-inline--fa fa-shopping-cart fa-w-18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
        <path d="m528.12 301.319 47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z"/>
    </svg>
    <svg v-else-if="name === 'angle-right'" aria-hidden="true" data-prefix="fas" data-icon="angle-right" class="svg-inline--fa fa-angle-right fa-w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
        <path d="m224.3 273-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"/>
    </svg>
    <svg v-else-if="name === 'angle-down'" aria-hidden="true" data-prefix="fas" data-icon="angle-down" class="svg-inline--fa fa-angle-down fa-w-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
        <path d="M143 352.3 7 216.3a23.9 23.9 0 0 1 0-33.9l22.6-22.6a23.9 23.9 0 0 1 33.9 0l96.4 96.4 96.4-96.4a23.9 23.9 0 0 1 33.9 0l22.6 22.6a23.9 23.9 0 0 1 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z"/>
    </svg>
    <svg v-else-if="name === 'angle-left'" aria-hidden="true" data-prefix="fas" data-icon="angle-left" class="svg-inline--fa fa-angle-left fa-w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
        <path d="m31.7 239 136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z"/>
    </svg>
    <svg v-else-if="name === 'spinner'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
    </svg>
    <svg v-else-if="name === 'search'" aria-hidden="true" data-prefix="fas" data-icon="search" class="svg-inline--fa fa-search fa-w-16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <path d="M505 442.7 405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7a23.9 23.9 0 0 0 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"/>
    </svg>
</template>

<script>
    import { defineComponent } from "vue";
    export default defineComponent({
        props: ['name'],
    })
</script>
