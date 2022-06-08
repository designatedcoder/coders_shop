<template>
    <app-layout title="Checkout">
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-4 sm:px-6 md:flex md:space-y-0 md:space-x-4 lg:px-8">
            <template v-if="isConfirmed">
                <Confirmation :order="order" />
            </template>
            <template v-else>
                <div class="flex-1">
                    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                        <form id="payment-form" @submit.prevent="processPayment">
                            <div class="-mx-3 md:flex mb-6">
                                <div class="px-3 mb-6 w-full md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                                        Name
                                    </label>
                                    <input type="text" class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-2 px-4" id="name" autofocus required v-model="form.name">
                                    <span class="flex justify-center text-md text-red-600 mt-2" v-if="errors.name">
                                        {{ errors.name[0] }}
                                    </span>
                                </div>
                            </div>
                            <div class="-mx-3 md:flex mb-6">
                                <div class="px-3 mb-6 w-full md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="address">
                                        Address
                                    </label>
                                    <input type="text" class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-2 px-4" id="address" required v-model="form.address">
                                    <span class="flex justify-center text-md text-red-600 mt-2" v-if="errors.address">
                                        {{ errors.address[0] }}
                                    </span>
                                </div>
                            </div>
                            <div class="-mx-3 md:flex mb-2">
                                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="city">
                                        City
                                    </label>
                                    <input type="text" class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-2 px-4" id="city" required v-model="form.city">
                                    <span class="flex justify-center text-md text-red-600 mt-2" v-if="errors.city">
                                        {{ errors.city[0] }}
                                    </span>
                                </div>
                                <div class="md:w-1/2 px-3 mb-6">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="state">
                                        State
                                    </label>
                                    <div class="relative">
                                        <select class="block appearance-none w-full bg-gray-100 text-gray-700 border border-gray-400 py-2 px-4 pr-8 rounded" id="state" required :value="form.state" v-model="form.state">
                                            <option disabled value="">Please select one</option>
                                            <option v-for="(state, index) in states" :key="index" :selected="state === form.state">{{ state }}</option>
                                        </select>
                                    </div>
                                    <span class="flex justify-center text-md text-red-600 mt-2" v-if="errors.state">
                                        {{ errors.state[0] }}
                                    </span>
                                </div>
                                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="zip_code">
                                        Zip Code
                                    </label>
                                    <input type="text" class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-2 px-4" id="zip_code" required v-model="form.zip_code">
                                    <span class="flex justify-center text-md text-red-600 mt-2" v-if="errors.zip_code">
                                        {{ errors.zip_code[0] }}
                                    </span>
                                </div>
                            </div>
                            <div class="-mx-3 md:flex mb-6">
                                <div class="px-3 mb-6 w-full md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">
                                        E-mail
                                    </label>
                                    <input type="email" class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-2 px-4" id="email" required v-model="form.email">
                                    <span class="flex justify-center text-md text-red-600 mt-2" v-if="errors.email">
                                        {{ errors.email[0] }}
                                    </span>
                                </div>
                            </div>
                            <div class="-mx-3 mb-6">
                                <div class="px-3 mb-6 w-full">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name_on_card">
                                        Name on Card
                                    </label>
                                    <input type="text" class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-2 px-4" id="name_on_card" required v-model="form.name_on_card">
                                    <span class="flex justify-center text-md text-red-600 mt-2" v-if="errors.name_on_card">
                                        {{ errors.name_on_card[0] }}
                                    </span>
                                </div>
                                <div class="px-3 mb-6 w-full md:mb-0">
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="card_element">
                                        Credit Card
                                    </label>
                                    <div id="card-element"></div>
                                    <p id="card-error" role="alert">{{ cardError }}</p>
                                </div>
                            </div>
                            <div class="flex justify-center">
                                <yellow-button as="submit" class="text-sm" :class="{ 'opacity-50 cursor-not-allowed': disabled }" :disabled="disabled">
                                    <icon name="spinner" class="animate-spin h-5 w-5 fill-current" v-if="loading"></icon>
                                    <span v-else>Pay now</span>
                                </yellow-button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="flex-1">
                    <order-totals
                        :taxRate="cartTaxRate"
                        :subtotal="cartSubtotal"
                        :tax="newTax"
                        :code="code"
                        :discount="discount"
                        :newSubtotal="newSubtotal"
                        :total="newTotal"
                    ></order-totals>
                </div>
            </template>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3'
    import { loadStripe } from '@stripe/stripe-js'
    import AppLayout from '@/Layouts/AppLayout'
    import Confirmation from '@/Components/Confirmation'
    import OrderTotals from '@/Components/OrderTotals'
    import YellowButton from '@/Components/Buttons/YellowButton'
    import states from '@/states'
    export default defineComponent({
        props: [
            'cartTaxRate',
            'cartSubtotal',
            'newTax',
            'code',
            'discount',
            'newSubtotal',
            'newTotal',
        ],
        components: {
            Link,
            AppLayout,
            Confirmation,
            OrderTotals,
            YellowButton,
        },
        data() {
            return {
                cardElement: {},
                cardError: '',
                disabled: true,
                elements: {},
                errors: [],
                form: {
                    name: '',
                    email: '',
                    address: '',
                    city: '',
                    state: '',
                    zip_code: '',
                    name_on_card: '',
                },
                isConfirmed: false,
                loading: false,
                order: {},
                states,
                stripe: {},
                style: {
                    base: {
                        fontFamily: 'Montserrat, sans-serif',
                        fontSmoothing: "antialiased",
                        fontSize: "16px",
                    },
                    invalid: {
                        fontFamily: 'Montserrat, sans-serif',
                        color: "#ff0000",
                        iconColor: "#ff0000"
                    }
                },
            }
        },
        mounted() {
            this.initStripe()
        },
        methods: {
            async initStripe() {
                this.stripe = await loadStripe(process.env.MIX_STRIPE_KEY)
                this.elements = this.stripe.elements()
                this.cardElement = this.elements.create("card", {
                    style: this.style,
                    hidePostalCode: true,
                })
                this.cardElement.mount("#card-element")
                this.cardElement.on('change', (event) => {
                    this.disabled = false
                    this.cardError = event.error ? event.error.message : ""
                })
            },
            async processPayment() {
                this.loading = true
                this.disabled = true
                const { paymentMethod, error } = await this.stripe.createPaymentMethod({
                    type: 'card',
                    card: this.cardElement,
                    billing_details: {
                        name: this.form.name,
                        email: this.form.email,
                        address: {
                            line1: this.form.address,
                            city: this.form.city,
                            state: this.form.state,
                            postal_code: this.form.zip_code
                        }
                    }
                })
                if(error) {
                    this.loading = true
                    if (error.param === 'billing_details[name]') {
                        this.cardError = 'The name is required!'
                    } else if (error.param === 'billing_details[email]') {
                        this.cardError = 'The email is required!'
                    }
                } else {
                    this.loading = false
                    this.form.payment_method_id = paymentMethod.id
                    this.form.amount = this.newTotal
                    this.checkout()
                }
            },
            checkout() {
                axios.post('/checkout', this.form)
                    .then((resp) => {
                        this.order = resp.data.order
                        this.isConfirmed = true
                    })
                    .catch((err) => {
                        if (err.response.status === 422) {
                            this.errors = err.response.data.errors
                        } else {
                            this.errors = []
                            err.response.status === 500 ?
                            this.cardError = err.response.data.errors :
                            err.response.data.message
                        }
                    })
            }
        }
    })
</script>
