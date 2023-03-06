import './bootstrap';
import '../css/app.scss';
import "vue-toastification/dist/index.css";

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import VueToastificationPlugin, {POSITION} from "vue-toastification";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

// noinspection JSIgnoredPromiseFromCall,JSCheckFunctionSignatures
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        // noinspection JSUnresolvedReference,JSCheckFunctionSignatures
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(VueToastificationPlugin, {
                position: POSITION.TOP_RIGHT,
            })
            .mount(el);
    },
});

InertiaProgress.init({ color: 'rgba(18,106,234,0.73)' });
