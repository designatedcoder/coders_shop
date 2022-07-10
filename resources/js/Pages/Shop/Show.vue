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
                <auto-complete></auto-complete>
            </template>
        </secondary-header>
        <div class="max-w-7xl mx-auto px-4 py-4 sm:flex sm:space-x-4 sm:px-6 lg:px-8">
            <div class="flex flex-col flex-1 sm:border-r">
                <div class="border-2 overflow-hidden cursor-zoom-in h-full">
                    <div id="img-container" class="w-full h-full">
                        <img id="current-img" :src="'/storage/'+currentImg" :alt="product.name" class="w-full h-full object-cover origin-center">
                    </div>
                </div>
                <div class="mt-6" v-if="product.alt_images">
                    <Carousel :settings="settings" :breakpoints="breakpoints">
                        <Slide v-for="(image, index) in slides" :key="index" class="cursor-pointer border-2 border-black hover:border-blue-600" :class="{ selected: index === isActive, 'border-red-600': index === isActive }" @click.prevent="changeCurrentImage(image, index)">
                            <div class="carousel__item flex w-full h-full">
                                <img :src="'/storage/'+image" class="object-cover" :class="{ 'opacity-50': index !== isActive  }">
                            </div>
                        </Slide>
                        <template #addons>
                            <Navigation />
                        </template>
                    </Carousel>
                    <!-- "\/images\/products\/January_2022\/alts\/kids-12.png" -->
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
                        <button type="button" class="flex justify-between items-center bg-gray-300 rounded-t px-4 py-4 w-full transition hover:text-white hover:bg-gray-700 sm:px-6 lg:px-8" @click.prevent="openDescription = !openDescription">
                            <span>Product Description</span>
                            <icon name="angle-down" class="w-5 h-5 text-yellow-500 fill-current" v-if="openDescription"></icon>
                            <icon name="angle-left" class="w-5 h-5 text-yellow-500 fill-current" v-else></icon>
                        </button>
                        <div class="bg-gray-50 px-4 py-4 sm:px-6 lg:px-8" v-if="openDescription">
                            <p>
                                {{ product.description }}
                            </p>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="flex justify-between items-center bg-gray-300 rounded-t px-4 py-4 w-full transition hover:text-white hover:bg-gray-700 sm:px-6 lg:px-8" @click.prevent="openFeatures = !openFeatures">
                            <span>Product Features</span>
                            <icon name="angle-down" class="w-5 h-5 text-yellow-500 fill-current" v-if="openFeatures"></icon>
                            <icon name="angle-left" class="w-5 h-5 text-yellow-500 fill-current" v-else></icon>
                        </button>
                        <div class="bg-gray-50 px-4 py-4 sm:px-6 lg:px-8" v-if="openFeatures">
                            <p>
                                {{ product.description }}
                            </p>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="flex justify-between items-center bg-gray-300 rounded-t px-4 py-4 w-full transition hover:text-white hover:bg-gray-700 sm:px-6 lg:px-8" @click.prevent="openReturn = !openReturn">
                            <span>Return Policy</span>
                            <icon name="angle-down" class="w-5 h-5 text-yellow-500 fill-current" v-if="openReturn"></icon>
                            <icon name="angle-left" class="w-5 h-5 text-yellow-500 fill-current" v-else></icon>
                        </button>
                        <div class="bg-gray-50 px-4 py-4 sm:px-6 lg:px-8" v-if="openReturn">
                            <p>
                                Don't worry about returns, we'll send you a new one!
                            </p>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="flex justify-between items-center bg-gray-300 rounded-t px-4 py-4 w-full transition hover:text-white hover:bg-gray-700 sm:px-6 lg:px-8" @click.prevent="openReviews = !openReviews">
                            <span>Reviews</span>
                            <icon name="angle-down" class="w-5 h-5 text-yellow-500 fill-current" v-if="openReviews"></icon>
                            <icon name="angle-left" class="w-5 h-5 text-yellow-500 fill-current" v-else></icon>
                        </button>
                        <div class="bg-gray-50 px-4 py-4 sm:px-6 lg:px-8" v-if="openReviews">
                            <p>
                                It's fantastic!
                            </p>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <p>Suggested based on your search</p>
                </div>
                <div class="flex space-x-4">
                    <Link :href="route('shop.show', item.slug)" class="flex border border-black w-1/4 h-24" v-for="(item, index) in similarProducts"  :key="index">
                        <img :src="'/storage/'+item.main_image" :alt="item.name" class="w-full object-cover">
                    </Link>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3'
    import { Carousel, Slide, Navigation } from 'vue3-carousel';
    import AppLayout from '@/Layouts/AppLayout'
    import AutoComplete from '@/Components/Search/AutoComplete'
    import GrayButton from '@/Components/Buttons/GrayButton'
    import SecondaryHeader from '@/Components/SecondaryHeader'
    export default defineComponent({
        props: ['product', 'similarProducts'],
        components: {
            Link,
            AppLayout,
            AutoComplete,
            GrayButton,
            SecondaryHeader,
            Carousel,
            Slide,
            Navigation,
        },
        data() {
            return {
                currentImg: this.product.main_image,
                isActive: 0,
                selected: false,
                openDescription: false,
                openFeatures: false,
                openReturn: false,
                openReviews: false,
                quantity: 1,
                form: this.$inertia.form({
                    id: this.product.id,
                    name: this.product.name,
                    price: this.product.price,
                    product_code: this.product.product_code,
                    details: this.product.details,
                    main_image: this.product.main_image,
                    alt_images: this.product.alt_images,
                    slug: this.product.slug,
                    quantity: 1,
                    totalQty: this.product.quantity,
                }),
                slides: this.product.alt_images,
                settings: {
                    itemsToShow: 1,
                    snapAlign: 'center',
                },
                // breakpoints are mobile first
                // any settings not specified will fallback to the carousel settings
                breakpoints: {
                    // 700px and up
                    700: {
                        itemsToShow: 3.5,
                        snapAlign: 'center',
                    },
                    // 1024 and up
                    1024: {
                        itemsToShow: 5,
                        snapAlign: 'start',
                    },
                },
            }
        },
        mounted() {
            this.zoomImage()
        },
        methods: {
            submit() {
                this.form.post(this.route('cart.store', this.form), {
                    preserveScroll: true,
                    onSuccess: () => {
                        Toast.fire({
                            icon: 'success',
                            title: `${this.form.name} has successfully been added to your cart!`
                        })
                    }
                })
            },
            changeCurrentImage(image, index) {
                if (image) {
                    this.currentImg = image
                    this.isActive = index
                    this.selected = false
                } else {
                    this.currentImg = this.product.main_image
                    if (this.isActive = index) {
                        this.selected = false
                    } else {
                        this.selected = true
                    }
                }
            },
            zoomImage() {
                let container = document.querySelector('#img-container')
                let img = document.querySelector('#current-img')
                container.addEventListener("mousemove", (e) => {
                    let x = e.clientX - e.target.offsetLeft
                    let y = e.clientY - e.target.offsetTop
                    img.style.transformOrigin = `${x}px ${y}px`
                    img.style.transform = "scale(3)"
                })
                container.addEventListener("mouseleave", () => {
                    img.style.transformOrigin = "center"
                    img.style.transform = "scale(1)"
                })
            }
        }
    })
</script>
