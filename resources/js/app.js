import Vue from 'vue'
import VueRouter from 'vue-router'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
Vue.component('pagination', require('laravel-vue-pagination'));

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
Vue.use(VueRouter)
import router from './routes'
import App from './components/App'
import vuetify from './vuetify';
import Swal from 'sweetalert2';
window.Swal=Swal

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    vuetify
});
export default app;