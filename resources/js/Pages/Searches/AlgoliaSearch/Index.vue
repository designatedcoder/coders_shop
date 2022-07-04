<template>
    <app-layout title="Search Algolia">
        <secondary-header>
            <template #breadcrumbs>
                <icon name="angle-right" class="w-4 h-4 fill-current"></icon>
                <span>Search Coder's Shop</span>
            </template>
        </secondary-header>
        <ais-instant-search
            :search-client="searchClient"
            :index-name="indexName"
            class="flex flex-col space-y-4 max-w-7xl mx-auto my-4 py-2 px-4 sm:flex-row sm:space-y-0 sm:space-x-4 md:px-6 lg:px-8"
        >
            <div>
                <ais-search-box :placeholder="placeholder" />
                <ais-stats class="text-center mt-4 font-semibold" />
                <ais-refinement-list
                    :attribute="attribute"
                    :sort-by="['isRefined', 'price:asc']"
                    class="flex justify-center mt-4 sm:justify-start"
                />
                <ais-powered-by class="flex justify-center mt-4 sm:justify-end" />
            </div>
            <ais-configure :hits-per-page.camel="5" />

            <div>
                <ais-hits>
                    <template v-slot:item="{ item }">
                        <Link :href="route('shop.show', item.slug)" class="flex space-x-8">
                            <div class="flex w-24 h-24">
                                <img :src="'/storage/'+item.main_image" :alt="item.name" class="object-cover">
                            </div>
                            <div class="flex flex-col">
                                <h3 class="text-xl font-semibold">
                                    <ais-highlight :hit="item" attribute="name" />
                                </h3>
                                <span>{{ item.description }}</span>
                                <span>{{ $filters.formatCurrency(item.price) }}</span>
                            </div>
                        </Link>
                    </template>
                </ais-hits>
                <ais-pagination class="flex justify-center mt-4" />
            </div>

        </ais-instant-search>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3'
    import algoliasearch from 'algoliasearch/lite'
    import AppLayout from '@/Layouts/AppLayout'
    import SecondaryHeader from '@/Components/SecondaryHeader'
    export default defineComponent({
        props: ['products'],
        components: {
            Link,
            AppLayout,
            SecondaryHeader,
        },
        data() {
            return {
                indexName: 'products',
                placeholder: 'Search ...',
                attribute: 'categories',
                searchClient: algoliasearch(
                    process.env.MIX_ALGOLIA_APP_ID,
                    process.env.MIX_ALGOLIA_SEARCH,
                )
            }
        }
    })
</script>

