<template>
    <Link :href="href" :class="classes" v-if="as === 'href'">
        <slot></slot>
    </Link>
    <button :class="classes" v-else>
        <slot></slot>
    </button>
</template>

<script>
    import { defineComponent } from "vue";
    import { Link } from '@inertiajs/inertia-vue3'
    export default defineComponent({
        components: {
            Link,
        },
        props: ['active', 'href', 'as'],
        computed: {
            classes() {
                return 'inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded font-semibold text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 transition'
            }
        }
    })
</script>
