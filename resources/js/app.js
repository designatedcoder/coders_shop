require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import Icons from './Components/Icons'

import InstantSearch from 'vue-instantsearch/vue3/es'

window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 5000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        const VueApp = createApp({ render: () => h(app, props) })
        VueApp.config.globalProperties.$filters = {
            formatCurrency(value) {
                value = (value/100)
                return value.toLocaleString('en-US', {
                    style: 'currency',
                    currency: 'USD'
                })
            }
        }
        VueApp
            .use(plugin)
            .use(InstantSearch)
            .mixin({ methods: { route } })
            .component('icon', Icons)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
