// router/index.js
import { createRouter, createWebHistory } from 'vue-router'
import InicioSesion from '../components/InicioSesion.vue'
import JuegosPage from '../components/JuegosPage.vue'
import EventosPage from '../components/EventosPage.vue'
import HomeView from '@/views/HomeView.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: HomeView
  },
  {
    path: '/juegos',
    name: 'Juegos',
    component: JuegosPage
  },
  {
    path: '/eventos',
    name: 'Eventos',
    component: EventosPage
  },
  {
    path: '/inicio-sesion',
    name: 'InicioSesion',
    component: InicioSesion
  },
  // Redirección para rutas antiguas
  {
    path: '/login',
    redirect: '/inicio-sesion'
  },
  {
    path: '/InicioSesion',
    redirect: '/inicio-sesion'
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
