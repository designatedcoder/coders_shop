<template>
    <app-layout :title="`Shop ${ categoryName }`">
        <secondary-header>
            <template #breadcrumbs>
                <icon name="angle-right" class="w-4 h-4 fill-current"></icon>
                <span>Shop {{ categoryName }}</span>
            </template>
            <template #search>
                <auto-complete></auto-complete>
            </template>
        </secondary-header>
        <div class="flex">
            <div class="border-r w-1/5">
                <div>
                    <div class="text-white text-center bg-gray-700 py-4">
                        <p>Shop By Category</p>
                    </div>
                    <div class="flex flex-col divide-y">
                        <Link :href="route('shop.index', { category: category.slug })" class="text-left px-4 py-4 transition hover:text-white hover:bg-gray-700 sm:px-6 lg:px-8" :class="route().current('shop.index', { category: category.slug}) ? 'bg-gray-700 text-white' : ''" v-for="(category, index) in categories" :key="index">
                            {{ category.name }}
                        </Link>
                    </div>
                </div>
            </div>
            <div class="border-l w-4/5">
                <div class="flex justify-end space-x-2 pt-4 pr-4" v-if="categorySlug">
                    <span class="font-bold">Price:</span>
                    <Link :href="route('shop.index', { category: categorySlug, sort: 'low_high'})" class="hover:text-yellow-500">Low to High</Link>
                    <span>|</span>
                    <Link :href="route('shop.index', { category: categorySlug, sort: 'high_low'})" class="hover:text-yellow-500">High to Low</Link>
                </div>
                <div class="container flex flex-wrap mx-auto">
                    <template v-if="products.length === 0">
                        <no-items-found></no-items-found>
                    </template>
                    <Link :href="route('shop.show', product.slug)" class="flex flex-col w-full p-4 rounded sm:w-1/2 md:w-1/3" v-for="(product, index) in products" :key="index" v-else>
                        <img :src="'/storage/'+product.main_image" :alt="product.name" class="h-72 object-cover md:w-72 lg:w-96">
                        <div class="flex justify-around bg-gray-700 py-2">
                            <span class="text-yellow-500">{{ $filters.formatCurrency(product.price) }}</span>
                            <span class="text-white">{{ product.name }}</span>
                        </div>
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
    import AutoComplete from '@/Components/Search/AutoComplete'
    import NoItemsFound from '@/Components/NoItemsFound'
    import SecondaryHeader from '@/Components/SecondaryHeader'
    export default defineComponent({
        props: ['products', 'categories', 'categoryName', 'categorySlug'],
        components: {
            Link,
            AppLayout,
            AutoComplete,
            NoItemsFound,
            SecondaryHeader,
        }
    })
</script>
