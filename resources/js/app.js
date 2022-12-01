/**
 * Import the dependencies.
 *
 */
import '../css/app.css';
import mitt from 'mitt';
import Axios from 'axios';
import helpers from './helpers.js';
import { createApp, h } from 'vue';
import { InertiaProgress } from '@inertiajs/progress';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

/**
 * Assign the dependencies.
 *
 */
window.axios  = Axios;
window.events = mitt();

/**
 * Configure the history event listener.
 *
 */
window.addEventListener('popstate', (event) => disablePageCaching(event));

/**
 * Configure the XHR progress bar.
 *
 */
InertiaProgress.init({
    color       : '#ECC94B',
    includeCSS  : true,
    showSpinner : false,
});

/**
 * Load the pages.
 *
 */
let pages = import.meta.glob('../vue/pages/**/*.vue');

/**
 * Create the Inertia application.
 *
 */
window.addEventListener('DOMContentLoaded', () =>
{
    let path = (name) => resolvePageComponent(`../vue/pages/${name}.vue`, pages);

    createInertiaApp({
        resolve : name => path(name),
        setup({ el, App, props, plugin }) {
            window.app = createApp({
                render : () => h(App, {
                    initialPage      : JSON.parse(document.getElementById('app').dataset.page),
                    resolveComponent : name => path(name).then(module => bootstrap(module)),
                })
            });

            helpers.register();

            window.app.use(plugin).mount(el);
        },
    });
});