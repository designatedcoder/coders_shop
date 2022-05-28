<template>
    <div class="flex flex-wrap space-y-6 py-6 sm:justify-around sm:space-y-0">
        <div class="flex flex-col w-full sm:w-1/4">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex flex-col">
                    <Link :href="route('profile.show')" class="border-t px-6 py-2 hover:bg-gray-500 hover:text-gray-50" :class="route().current('profile.show') ? 'bg-gray-700 text-white' : ''">Edit Profile</Link>
                    <Link :href="route('orders.index')" class="border-t px-6 py-2 hover:bg-gray-500 hover:text-gray-50" :class="route().current('orders.index') ? 'bg-gray-700 text-white' : ''">Orders</Link>
                    <Link :href="route('shop.index')" class="border-t px-6 py-2 hover:bg-gray-500 hover:text-gray-50" :class="route().current('shop.index') ? 'bg-gray-700 text-white' : ''">Shop</Link>
                </div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-xl py-6 w-full sm:w-2/3 sm:rounded-lg">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3'
    export default defineComponent({
        components: {
            Link,
        }
    })
</script>
