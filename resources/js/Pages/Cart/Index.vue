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
                <div class="flex justify-between border-t border-b border-black py-2">
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
                                    <form>
                                        <button type="submit" class="hover:text-yellow-500">
                                            Remove
                                        </button>
                                    </form>
                                    <form>
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
                    <p>You have saved no items for later!</p>
                    <p>5 item(s) saved for later</p>
                </div>
                <div class="flex justify-between border-t border-b border-black py-2">
                    <div class="w-1/3">Item</div>
                    <div class="flex justify-between w-1/2">
                        <span class="flex-1 tex-center">Quantity</span>
                        <span class="flex-1 text-right">Price</span>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between border-b border-black py-2">
                        <div class="flex space-x-4 w-1/2">
                            <Link href="#">
                                <img :src="'/storage/images/site_images/hand_craft.jpg'" alt="" class="object-cover">
                            </Link>
                            <div class="flex flex-1 flex-col justify-between">
                                <Link href="#" class="flex flex-col">
                                    <span>aoisejfoesj</span>
                                    <span>aoiejfjsjjjjjjjjjjjjj</span>
                                </Link>
                                <div class="flex flex-col mt-4">
                                    <form>
                                        <button type="submit" class="hover:text-yellow-500">
                                            Remove
                                        </button>
                                    </form>
                                    <form>
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
                                $5.99 ea.
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
        props: ['cartItems', 'cartTaxRate', 'cartSubtotal', 'cartTax', 'newTotal'],
        components: {
            Link,
            AppLayout,
            OrderTotals,
        }
    })
</script>
