<template>
    <app-layout title="My Orders">
        <main-layout>
            <h1 class="text-2xl font-semibold px-6">My Orders</h1>
            <template v-if="orders.data.length === 0">
                <no-items-found></no-items-found>
            </template>
            <template v-else>
                <div class="flex flex-col space-y-2 px-6 py-2">
                    <div v-for="(order, index) in orders.data" :key="index">
                        <div class="flex justify-between bg-gray-700 text-sm text-white rounded-t px-6 py-2 w-full">
                            <div class="flex flex-col">
                                <span>Order Placed</span>
                                <span>{{ order.created_at }}</span>
                            </div>
                            <div class="flex flex-col">
                                <span>Total</span>
                                <span>{{ $filters.formatCurrency(order.billing_total) }}</span>
                            </div>
                            <div class="flex flex-col text-right">
                                <span>Order # {{ order.confirmation_number }}</span>
                                <div>
                                    <yellow-button as="href" :href="route('orders.show', order.confirmation_number)" class="py-1">
                                        <span>View Invoice</span>
                                    </yellow-button>
                                </div>
                            </div>
                        </div>
                        <div class="border rounded-b divide-y space-y-4 px-6 py-2">
                            <div v-for="(product, index) in order.products" :key="index">
                                <Link :href="route('shop.show', product.slug)" class="flex justify-between space-x-4 divide-x py-6">
                                    <div class="flex-1">
                                        <img :src="'/storage/'+product.main_image" :alt="product.name" class="object-cover">
                                    </div>
                                    <div class="flex-1 pl-4">
                                        <span>{{ product.name }}</span>
                                        <p>{{ product.details }}</p>
                                        <p>{{ product.description }}</p>
                                    </div>
                                </Link>
                            </div>
                        </div>

                    </div>
                </div>
                <nav>
                    <ul class="flex justify-center space-x-1 px-6 py-2">
                        <li class="rounded px-2 py-1"
                            :class="[
                                link.url === null ? 'disabled' : '',
                                link.active ? 'bg-gray-400 text-gray-700 hover:bg-gray-900 hover:text-gray-400' : 'bg-gray-900 text-gray-400 hover:bg-gray-400 hover:text-gray-700'
                            ]"
                            v-for="(link, index) in orders.links"
                            :key="index"
                        >
                            <Link :href="link.url === null ? '#' : link.url" v-html="link.label"></Link>
                        </li>
                    </ul>
                </nav>
            </template>
        </main-layout>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue';
    import { Link } from '@inertiajs/inertia-vue3'
    import AppLayout from '@/Layouts/AppLayout'
    import MainLayout from '@/Layouts/MainLayout'
    import NoItemsFound from '@/Components/NoItemsFound'
    import YellowButton from '@/Components/Buttons/YellowButton'
    export default defineComponent({
        props: ['orders'],
        components: {
            Link,
            AppLayout,
            MainLayout,
            NoItemsFound,
            YellowButton,
        }
    })
</script>
