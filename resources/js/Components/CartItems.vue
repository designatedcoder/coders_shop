<template>
    <div class="flex justify-between border-t border-b border-black py-2" v-if="count > 0">
        <div class="w-1/3">Item</div>
        <div class="flex justify-between w-1/2">
            <span class="flex-1 tex-center">Quantity</span>
            <span class="flex-1 text-right">Price</span>
        </div>
    </div>
    <div>
        <div class="flex justify-between border-b border-black py-2" v-for="(item, index) in items" :key="index">
            <div class="flex space-x-4 w-1/2">
                <Link :href="route('shop.show', item.options.slug)" class="flex flex-1">
                    <img :src="'/storage/'+item.options.main_image" :alt="item.name" class="object-cover">
                </Link>
                <div class="flex flex-1 flex-col justify-between">
                    <Link :href="route('shop.show', item.options.slug)" class="flex flex-col">
                        <span>{{ item.name }}</span>
                        <span>{{ item.options.details }}</span>
                    </Link>
                    <div class="flex flex-col mt-4">
                        <form @submit.prevent="remove(item.rowId)">
                            <button type="submit" class="hover:text-yellow-500">
                                Remove
                            </button>
                        </form>
                        <form @submit.prevent="later(item.rowId)">
                            <button type="submit" class="hover:text-yellow-500">
                                {{ actionText }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="flex justify-between w-1/2">
                <div class="flex-1 text-center">
                    <select class="border bg-white rounded outline-none py-0" tabindex="1" v-model="item.qty" @change="update(item.rowId, item.qty)">
                        <option :value="qty" :selected="qty===item.qty" v-for="(qty, index) in item.options.totalQty" :key="index">
                            {{ qty }}
                        </option>
                    </select>
                </div>
                <span class="flex-1 text-right">
                    {{ $filters.formatCurrency(item.price) }} ea.
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';
    export default defineComponent({
        props: [
            'count',
            'items',
            'later',
            'remove',
            'update',
            'actionText',
        ],
        components: {
            Link,
        },
    })
</script>
