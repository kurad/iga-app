import { createRouter, createWebHistory } from 'vue-router'
// import HomeView from '../views/HomeView.vue'
import LevelsIndex from '../components/LevelIndex.vue';
import Dashboard from '../components/Dashboard.vue';

const routes = [
  {
    path: '/levels',
    name: 'levels',
    component: LevelsIndex
  },
  {
    path: '/home',
    name: 'home',
    component: Dashboard
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})


export default router
