<template>
    <app-layout :title="'My Order: '+`${order.confirmation_number}`">
        <main-layout>
            <h1 class="text-xl font-semibold px-6">Order # {{ order.confirmation_number }}</h1>
            <div class="flex flex-col space-y-2 px-6 py-2">
                <div>
                    <div class="flex justify-between items-center bg-gray-700 text-sm text-white rounded-t px-6 py-2 w-full">
                        <form @submit.prevent="print">
                            <yellow-button as="submit" class="py-1">
                                <span>Print Invoice</span>
                            </yellow-button>
                        </form>

                        <div class="flex flex-col text-right">
                            <span>Order Placed:</span>
                            <span>{{ order.created_at }}</span>
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
                    <div class="flex justify-end border-t border-b border-black py-2">
                        <div class="flex flex-col">
                            <div class="flex justify-end space-x-2">
                                <span>Subtotal:</span>
                                <span>{{ $filters.formatCurrency(order.billing_subtotal) }}</span>
                            </div>
                            <div class="flex justify-end space-x-2" v-if="order.billing_discount_code">
                                <span>Discount: ({{ order.billing_discount_code }})</span>
                                <span>-{{ $filters.formatCurrency(order.billing_discount) }}</span>
                            </div>
                            <div class="flex justify-end space-x-2">
                                <span>Tax:</span>
                                <span>{{ $filters.formatCurrency(order.billing_tax) }}</span>
                            </div>
                            <div class="flex justify-end space-x-2">
                                <span>Total:</span>
                                <span>{{ $filters.formatCurrency(order.billing_total) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main-layout>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue';
    import { Link } from '@inertiajs/inertia-vue3'
    import AppLayout from '@/Layouts/AppLayout'
    import MainLayout from '@/Layouts/MainLayout'
    import YellowButton from '@/Components/Buttons/YellowButton'
    export default defineComponent({
        props: ['order'],
        components: {
            Link,
            AppLayout,
            MainLayout,
            YellowButton,
        },
        data() {
            return {
                form: this.$inertia.form({
                    order: this.order.confirmation_number
                })
            }
        },
        methods: {
            print() {
                this.form.post(this.route('invoice.store', this.form.order))
            }
        }
    })
</script>
