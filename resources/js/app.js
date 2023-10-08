
import './bootstrap';
import { createApp } from 'vue';
import jQuery from 'jquery'
// import VueRouter from 'vue-router'


window.$ = window.jQuery = jQuery;

const app = createApp({});

import router from './router/router.js';
import DashboardComponent from './components/Dashboard.vue';
import LevelsComponent from './components/LevelIndex.vue';
import SideBar from './components/SideBar.vue';
app.component('dashboard-component', DashboardComponent);
app.component('levels-component', LevelsComponent);
app.component('sidebar', SideBar);


app.use(router).mount('#app');
