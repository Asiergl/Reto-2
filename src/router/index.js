// router/index.js
import { createRouter, createWebHistory } from 'vue-router'
//Importar ?¿components corregir?¿
import InicioSesion from '../components/InicioSesion.vue'
//Importar las views
import HomeView from '@/views/HomeView.vue'
import JuegosView from '@/views/Juegos.vue'
import EventosView from '@/views/Eventos.vue'
import MisEventos from '@/views/MisEventos.vue'
import CrearEvento from '@/views/CrearEvento.vue'

//?Crear la vista pronto o ya existe¿
//import LoginView from '@/views/LoginView.vue'
//import { name } from '@vue/eslint-config-prettier/skip-formatting'

const routes = [
  {
  path: '/crear-evento',
  name: 'CrearEvento',
  component: CrearEvento
  },

  {
    path: '/mis-eventos',
    name: 'MisEventos',
    component: MisEventos
  },

  {
    path: '/',
    name: 'Home',
    component: HomeView
  },

  {
    path: '/juegos',
    name: 'Juegos',
    component: JuegosView
  },

  {
    path: '/eventos',
    name: 'Eventos',
    component: EventosView
  },
  
  // Redirección para rutas antiguas
  {
    path: '/login',
    redirect: '/inicio-sesion'
  },

  // Redirección por si alguien escribe /inicio-sesion
  {
    path: '/inicio-sesion',
    redirect: '/login'
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL), // Mejor práctica en Vite
  routes
})

export default router
