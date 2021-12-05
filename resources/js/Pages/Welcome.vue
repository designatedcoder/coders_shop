<template>
    {{ products }}
</template>

<script>
    import { defineComponent } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        props: ['products'],
        components: {
            Head,
            Link,
        },
    })
</script>
