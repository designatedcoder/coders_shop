<template>
    <footer class="text-center text-white bg-gray-700 px-4 py-4">
        <div>
            <p>
                {{ randomQuote }}
            </p>
        </div>
    </footer>
</template>

<script>
    import { defineComponent } from 'vue'
    import quotes from '@/quotes'
    export default defineComponent({
        data() {
            return {
                quotes: quotes,
            }
        },
        computed: {
            randomQuote() {
                return this.quotes[Math.floor(Math.random()*this.quotes.length)]
            }
        }
    })
</script>
