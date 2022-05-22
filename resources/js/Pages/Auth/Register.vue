<template>
    <app-layout title="Register">
        <div class="max-w-7xl mx-auto px-4 py-4 space-y-4 sm:px-6 md:flex md:space-y-0 md:space-x-4 lg:px-8">
            <div class="flex-1">
                <div class="flex flex-col bg-white shadow-md rounded px-8 py-6">
                    <h1 class="text-lg font-semibold text-center underline italic">Register</h1>
                    <form @submit.prevent="submit">
                        <div>
                            <jet-label for="name" value="Name" />
                            <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus required autocomplete="name" />
                            <jet-input-error :message="form.errors.name" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <jet-label for="email" value="Email" />
                            <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
                            <jet-input-error :message="form.errors.email" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <jet-label for="password" value="Password" />
                            <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" autocomplete="new-password" required />
                            <jet-input-error :message="form.errors.password" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <jet-label for="password_confirmation" value="Confirm Password" />
                            <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" autocomplete="new-password" required />
                        </div>

                        <div class="mt-4">
                            <jet-label for="address" value="Street Address" />
                            <jet-input id="address" type="text" class="mt-1 block w-full" v-model="form.address" required />
                            <jet-input-error :message="form.errors.address" class="mt-2" />
                        </div>

                        <div class="flex flex-col mt-4 space-y-4 sm:flex-row sm:space-y-0 sm:space-x-2">
                            <div>
                                <jet-label for="city" value="City" />
                                <jet-input id="city" type="text" class="mt-1 w-full" required v-model="form.city" />
                                <jet-input-error :message="form.errors.city" class="mt-2" />
                            </div>
                            <div>
                                <jet-label for="state" value="State" />
                                <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 w-full" :value="form.state" id="state" required v-model="form.state">
                                    <option disabled value="">Please select one</option>
                                    <option v-for="(state, index) in states" :key="index" :selected="state === form.state">{{ state }}</option>
                                </select>
                                <jet-input-error :message="form.errors.state" class="mt-2" />
                            </div>
                            <div>
                                <jet-label for="zip_code" value="Postal Code" />
                                <jet-input id="zip_code" type="text" class="mt-1 w-full" required v-model="form.zip_code" />
                                <jet-input-error :message="form.errors.zip_code" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-center mt-4">
                            <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                <icon name="spinner" class="animate-spin h-5 w-5 fill-current" v-if="form.processing"></icon>
                                <span v-else>Register</span>
                            </jet-button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="flex-1">
                <div class=" flex flex-col shadow-md rounded">
                    <div class="bg-gray-300 px-4 py-6">
                        <div class="flex flex-col items-center bg-white px-4 py-2 space-y-4">
                            <Link :href="route('login')" class="underline text-gray-600 hover:text-gray-900 transition">
                                Already registered?
                            </Link>
                            <Link :href="route('guest.index')" class="underline text-gray-600 hover:text-gray-900 transition">
                                Checkout as a guest
                            </Link>
                            <Link :href="route('shop.index')" class="underline text-gray-600 hover:text-gray-900 transition">Continue Shopping.</Link>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import states from '@/states'

    export default defineComponent({
        components: {
            Link,
            AppLayout,
            JetButton,
            JetInput,
            JetInputError,
            JetLabel,
        },

        data() {
            return {
                states: states,
                form: this.$inertia.form({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    address: '',
                    city: '',
                    state: '',
                    zip_code: '',
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    })
</script>
