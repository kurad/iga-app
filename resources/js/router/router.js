import { createRouter, createWebHistory } from 'vue-router'
// import HomeView from '../views/HomeView.vue'
import LevelsIndex from '../components/LevelIndex.vue';
import Dashboard from '../components/Dashboard.vue';
import SchoolComponent from '../components/views/SchoolComponent.vue'

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
  {
    path: '/schools',
    name: 'schools',
    component: SchoolComponent
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})


export default router
