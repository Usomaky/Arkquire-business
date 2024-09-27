import './bootstrap';
import '../css/app.css';
import 'primeicons/primeicons.css';
import 'primevue/resources/themes/lara-light-teal/theme.css';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { InertiaProgress } from '@inertiajs/progress';
import PrimeVue from "primevue/config";
import ToastService from 'primevue/toastservice';
import Tooltip from 'primevue/tooltip';
import BadgeDirective from 'primevue/badgedirective';
import Ripple from 'primevue/ripple';

import { designStyles } from './PassThroughs/General';

createInertiaApp({
  resolve: name => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(PrimeVue, {
            ripple: true,
            pt:  designStyles,
            zIndex: {
                modal: 1100,        //dialog, sidebar
                overlay: 1000,      //dropdown, overlaypanel
                menu: 1000,         //overlay menus
                tooltip: 1100       //tooltip
            }
        })
      .use(ToastService)
      .directive('tooltip', Tooltip)
      .directive('badge', BadgeDirective)
      .directive('ripple', Ripple)
      .mount(el)
  },
});

InertiaProgress.init({ color: '#4B5563' });


