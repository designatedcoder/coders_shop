<template>
    <app-layout :title="product.name">
        <secondary-header>
            <template #breadcrumbs>
                <icon name="angle-right" class="w-4 h-4 fill-current"></icon>
                <Link :href="route('shop.index')" class="text-gray-700 transition hover:text-yellow-500">Shop</Link>
                <icon name="angle-right" class="w-4 h-4 fill-current"></icon>
                <span>{{ product.name }}</span>
            </template>
            <template #search>
                search
            </template>
        </secondary-header>
        <div class="max-w-7xl mx-auto px-4 py-4 sm:flex sm:space-x-4 sm:px-6 lg:px-8">
            <div class="flex-1 sm:border-r">
                <div class="border-2 p-2">
                    <img :src="'/storage/images/'+product.image" :alt="product.name" class="w-full object-cover">
                </div>
                <div class="flex space-x-4 mt-4">
                    <button type="button">
                        <icon name="angle-left" class="w-4 h-4 fill-current"></icon>
                    </button>
                    <div class="w-1/4">
                        <img :src="'/storage/images/'+product.image" :alt="product.name" class="object-cover">
                    </div>
                    <div class="w-1/4">
                        <img :src="'/storage/images/'+product.image" :alt="product.name" class="object-cover">
                    </div>
                    <div class="w-1/4">
                        <img :src="'/storage/images/'+product.image" :alt="product.name" class="object-cover">
                    </div>
                    <div class="w-1/4">
                        <img :src="'/storage/images/'+product.image" :alt="product.name" class="object-cover">
                    </div>
                    <button type="button">
                        <icon name="angle-right" class="w-4 h-4 fill-current"></icon>
                    </button>
                </div>
            </div>
            <div class="flex-1 space-y-6 my-4 sm:mt-0 sm:border-l sm:pl-4">
                <form @submit.prevent="submit">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-semibold capitalize italic">{{ product.name }}</h2>
                        <div class="text-xl capitalize italic">
                            <span>
                                Price:
                            </span>
                            <span>
                                {{ $filters.formatCurrency(product.price) }}
                            </span>
                        </div>
                    </div>

                    <div class="flex space-x-4 mt-4">
                        <p class="text-xl capitalize">
                            {{ product.details }}
                        </p>
                    </div>
                    <div class="flex space-x-4 mt-4">
                        <span class="text-xl capitalize">
                            Sku:
                        </span>
                        <p class="text-xl capitalize">
                            {{ product.product_code }}
                        </p>
                    </div>

                    <div class="mt-4">
                        <template v-if="product.quantity <= 0">
                            <div class="mt-4">
                                <span class="text-2xl text-red-600 font-semibold italic uppercase">
                                    Sold Out
                                </span>
                            </div>
                        </template>
                        <template v-else-if="product.quantity <= 5">
                            <div class="mt-4">
                                <span class="text-2xl text-yellow-600 font-semibold italic uppercase">
                                    Only a few left
                                </span>
                            </div>
                            <div class="flex items-center">
                                <label for="quantity" class="flex-1 text-xl capitalize">Qty:</label>
                                <select class="flex-1 w-full border bg-white rounded px-3 py-1 outline-none" tabindex="1" v-model="form.quantity">
                                    <option :value="qty" :selected="qty === quantity" v-for="(qty, index) in product.quantity" :key="index">{{ qty }}</option>
                                </select>
                            </div>
                        </template>
                        <template v-else>
                            <div class="flex items-center">
                                <label for="quantity" class="flex-1 text-xl capitalize">Qty:</label>
                                <select class="flex-1 w-full border bg-white rounded px-3 py-1 outline-none" tabindex="1" v-model="form.quantity">
                                    <option :value="qty" :selected="qty === quantity" v-for="(qty, index) in product.quantity" :key="index">{{ qty }}</option>
                                </select>
                            </div>
                        </template>
                    </div>
                    <div class="text-center mt-4" v-if="product.quantity > 0">
                        <gray-button as="submit" class="text-sm">
                            <span>Add to Cart</span>
                        </gray-button>
                    </div>
                </form>
                <div class="flex flex-col divide-y">
                    <div>
                        <button type="button" class="flex justify-between items-center bg-gray-300 rounded-t px-4 py-4 w-full transition hover:text-white hover:bg-gray-700 sm:px-6 lg:px-8">
                            <span>Product Description</span>
                        </button>
                    </div>
                    <div>
                        <button type="button" class="flex justify-between items-center bg-gray-300 rounded-t px-4 py-4 w-full transition hover:text-white hover:bg-gray-700 sm:px-6 lg:px-8">
                            <span>Product Features</span>
                        </button>
                    </div>
                    <div>
                        <button type="button" class="flex justify-between items-center bg-gray-300 rounded-t px-4 py-4 w-full transition hover:text-white hover:bg-gray-700 sm:px-6 lg:px-8">
                            <span>Return Policy</span>
                        </button>
                    </div>
                    <div>
                        <button type="button" class="flex justify-between items-center bg-gray-300 rounded-t px-4 py-4 w-full transition hover:text-white hover:bg-gray-700 sm:px-6 lg:px-8">
                            <span>Reviews</span>
                        </button>
                    </div>
                </div>
                <div class="text-center">
                    <p>Suggested based on your search</p>
                </div>
                <div class="flex space-x-4">
                    <Link href="#" class="flex border border-black w-1/4 h-24">
                        <img :src="'/storage/images/'+product.image" :alt="product.name" class="w-full object-cover">
                    </Link>
                    <Link href="#" class="flex border border-black w-1/4 h-24">
                        <img :src="'/storage/images/'+product.image" :alt="product.name" class="w-full object-cover">
                    </Link>
                    <Link href="#" class="flex border border-black w-1/4 h-24">
                        <img :src="'/storage/images/'+product.image" :alt="product.name" class="w-full object-cover">
                    </Link>
                    <Link href="#" class="flex border border-black w-1/4 h-24">
                        <img :src="'/storage/images/'+product.image" :alt="product.name" class="w-full object-cover">
                    </Link>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3'
    import AppLayout from '@/Layouts/AppLayout'
    import GrayButton from '@/Components/Buttons/GrayButton'
    import SecondaryHeader from '@/Components/SecondaryHeader'
    export default defineComponent({
        props: ['product'],
        components: {
            Link,
            AppLayout,
            GrayButton,
            SecondaryHeader,
        },
        data() {
            return {
                quantity: 1,
                form: this.$inertia.form({
                    id: this.product.id,
                    name: this.product.name,
                    price: this.product.price,
                    product_code: this.product.product_code,
                    details: this.product.details,
                    image: this.product.image,
                    slug: this.product.slug,
                    quantity: 1,
                    totalQty: this.product.quantity,
                })
            }
        },
        methods: {
            submit() {
                this.form.post(this.route('cart.store'), this.form), {
                    preserveScroll: true,
                    onSuccess: () => {}
                }
            }
        }
    })
</script>
