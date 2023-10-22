
import './bootstrap';
import { createApp } from 'vue';
import jQuery from 'jquery'
import router from './router';
import sidebar from './components/SideBar.vue'

// import VueRouter from 'vue-router'


window.$ = window.jQuery = jQuery;

const app = createApp({
    components: {
        sidebar
    }
}).use(router).mount('#app')

