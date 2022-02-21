<template>
    <app-layout title="Cart">
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-4 sm:px-6 md:flex md:space-y-0 md:space-x-4 lg:px-8">
            <div class="flex-1">
                <div class="flex flex-col items-center mb-2 md:flex-row md:justify-between">
                    <p class="text-red-600 text-2xl font-semibold" v-if="$page.props.cartCount <= 0">
                        Your cart is empty!
                    </p>
                    <p class="text-red-600 text-2xl font-semibold" v-else>
                        {{ $page.props.cartCount }} item(s) in cart
                    </p>
                    <Link :href="route('shop.index')" class="underline hover:text-red-700 transition">Continue Shopping</Link>
                </div>
                <div class="flex justify-between border-t border-b border-black py-2" v-if="$page.props.cartCount > 0">
                    <div class="w-1/3">Item</div>
                    <div class="flex justify-between w-1/2">
                        <span class="flex-1 tex-center">Quantity</span>
                        <span class="flex-1 text-right">Price</span>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between border-b border-black py-2" v-for="(item, index) in cartItems" :key="index">
                        <div class="flex space-x-4 w-1/2">
                            <Link :href="route('shop.show', item.options.slug)" class="flex flex-1">
                                <img :src="'/storage/images/'+item.options.image" :alt="item.name" class="object-cover">
                            </Link>
                            <div class="flex flex-1 flex-col justify-between">
                                <Link :href="route('shop.show', item.options.slug)" class="flex flex-col">
                                    <span>{{ item.name }}</span>
                                    <span>{{ item.options.details }}</span>
                                </Link>
                                <div class="flex flex-col mt-4">
                                    <form @submit.prevent="deleteFromCart(item.rowId)">
                                        <button type="submit" class="hover:text-yellow-500">
                                            Remove
                                        </button>
                                    </form>
                                    <form @submit.prevent="addToLaterCart(item.rowId)">
                                        <button type="submit" class="hover:text-yellow-500">
                                            Save for later
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between w-1/2">
                            <div class="flex-1 text-center">
                                <select class="border bg-white rounded outline-none py-0" tabindex="1">
                                    <option value="1">1</option>
                                </select>
                            </div>
                            <span class="flex-1 text-right">
                                {{ $filters.formatCurrency(item.price) }} ea.
                            </span>
                        </div>
                    </div>
                </div>
                <div class="text-center text-red-600 text-2xl font-semibold mt-4 mb-2 md:text-left">
                    <p v-if="laterCount <= 0">You have saved no items for later!</p>
                    <p v-else>{{ laterCount }} item(s) saved for later</p>
                </div>
                <div class="flex justify-between border-t border-b border-black py-2" v-if="laterCount > 0">
                    <div class="w-1/3">Item</div>
                    <div class="flex justify-between w-1/2">
                        <span class="flex-1 tex-center">Quantity</span>
                        <span class="flex-1 text-right">Price</span>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between border-b border-black py-2" v-for="(item, index) in laterItems" :key="index">
                        <div class="flex space-x-4 w-1/2">
                            <Link :href="route('shop.show', item.options.slug)">
                                <img :src="'/storage/images/'+item.options.image" :alt="item.name" class="object-cover">
                            </Link>
                            <div class="flex flex-1 flex-col justify-between">
                                <Link :href="route('shop.show', item.options.slug)" class="flex flex-col">
                                    <span>{{ item.name }}</span>
                                    <span>{{ item.options.details }}</span>
                                </Link>
                                <div class="flex flex-col mt-4">
                                    <form @submit.prevent="deleteFromLater(item.rowId)">
                                        <button type="submit" class="hover:text-yellow-500">
                                            Remove
                                        </button>
                                    </form>
                                    <form @submit.prevent="addToCart(item.rowId)">
                                        <button type="submit" class="hover:text-yellow-500">
                                            Move to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between w-1/2">
                            <div class="flex-1 text-center">
                                <select class="border bg-white rounded outline-none py-0" tabindex="1">
                                    <option value="1">1</option>
                                </select>
                            </div>
                            <span class="flex-1 text-right">
                                {{ $filters.formatCurrency(item.price) }} ea.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-1">
                <order-totals
                    :taxRate="cartTaxRate"
                    :subtotal="cartSubtotal"
                    :tax="cartTax"
                    :total="newTotal"
                ></order-totals>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue';
    import { Link } from '@inertiajs/inertia-vue3'
    import AppLayout from '@/Layouts/AppLayout'
    import OrderTotals from '@/Components/OrderTotals'
    export default defineComponent({
        props: ['cartItems', 'cartTaxRate', 'cartSubtotal', 'cartTax', 'newTotal', 'laterItems', 'laterCount'],
        components: {
            Link,
            AppLayout,
            OrderTotals,
        },
        data() {
            return {
                quantity: 1,
                index: 1,
                form: this.$inertia.form({
                    cartItems: this.cartItems,
                    quantity: 0,
                })
            }
        },
        methods: {
            addToLaterCart(id) {
                this.form.post(this.route('later.store', id), {
                    preserveScroll: true,
                    onSuccess:()=> {
                        console.log(id)
                    }
                })
            },
            addToCart(id) {
                this.form.post(this.route('later.moveToCart', id), {
                    preserveScroll: true,
                    onSuccess:()=> {
                        console.log(id)
                    }
                })
            },
            deleteFromCart(id) {
                this.form.delete(this.route('cart.destroy', id), {
                    preserveScroll: true,
                    onSuccess:()=> {
                        console.log(id)
                    }
                })
            },
            deleteFromLater(id) {
                this.form.delete(this.route('later.destroy', id), {
                    preserveScroll: true,
                    onSuccess:()=> {
                        console.log(id)
                    }
                })
            }
        }
    })
</script>
