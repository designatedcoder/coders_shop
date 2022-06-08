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

                <cart-items :count="$page.props.cartCount" :items="cartItems" :later="addToLaterCart" :remove="deleteFromCart" :update="updateCart" :actionText="`Save for later`">
                    <slot></slot>
                </cart-items>

                <div class="text-center text-red-600 text-2xl font-semibold mt-4 mb-2 md:text-left">
                    <p v-if="laterCount <= 0">You have saved no items for later!</p>
                    <p v-else>{{ laterCount }} item(s) saved for later</p>
                </div>

                <cart-items :count="laterCount" :items="laterItems" :later="addToCart" :remove="deleteFromLater" :update="updateLater" :actionText="`Move to Cart`">
                    <slot></slot>
                </cart-items>

            </div>
            <div class="flex-1">
                <order-totals
                    :taxRate="cartTaxRate"
                    :subtotal="cartSubtotal"
                    :tax="newTax"
                    :total="newTotal"
                    :newSubtotal="newSubtotal"
                    :code="code"
                    :discount="discount"
                ></order-totals>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue';
    import { Link } from '@inertiajs/inertia-vue3'
    import AppLayout from '@/Layouts/AppLayout'
    import CartItems from '@/Components/CartItems'
    import OrderTotals from '@/Components/OrderTotals'
    export default defineComponent({
        props: ['cartItems', 'cartTaxRate', 'cartSubtotal', 'newTax', 'newSubtotal', 'newTotal', 'code', 'discount', 'laterItems', 'laterCount'],
        components: {
            Link,
            AppLayout,
            CartItems,
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
            updateCart(id, quantity) {
                this.form.quantity = quantity
                this.form.patch(this.route('cart.update', id), {
                    preserveScroll: true,
                    onSuccess:() => {
                        Toast.fire({
                            icon: 'success',
                            title: 'Items in cart have successfully been updated!'
                        })
                    }
                })
            },
            updateLater(id, quantity) {
                this.form.quantity = quantity
                this.form.patch(this.route('later.update', id), {
                    preserveScroll: true,
                    onSuccess:() => {
                        Toast.fire({
                            icon: 'success',
                            title: 'Saved for later has successfully been updated!'
                        })
                    }
                })
            },
            addToLaterCart(id) {
                this.form.post(this.route('later.store', id), {
                    preserveScroll: true,
                    onSuccess:()=> {
                        Toast.fire({
                            icon: 'success',
                            title: 'Item has successfully been saved for later!'
                        })
                    }
                })
            },
            addToCart(id) {
                this.form.post(this.route('later.moveToCart', id), {
                    preserveScroll: true,
                    onSuccess:()=> {
                        Toast.fire({
                            icon: 'success',
                            title: 'Item has successfully been added to your cart!'
                        })
                    }
                })
            },
            deleteFromCart(id) {
                this.form.delete(this.route('cart.destroy', id), {
                    preserveScroll: true,
                    onSuccess:()=> {
                        Toast.fire({
                            icon: 'success',
                            title: 'Item has succesfully been removed from your cart!'
                        })
                    }
                })
            },
            deleteFromLater(id) {
                this.form.delete(this.route('later.destroy', id), {
                    preserveScroll: true,
                    onSuccess:()=> {
                        Toast.fire({
                            icon: 'success',
                            title: 'Item has successfully been removed from your saved for later items!'
                        })
                    }
                })
            }
        }
    })
</script>
