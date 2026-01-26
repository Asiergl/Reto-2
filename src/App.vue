<script setup>
import { RouterView } from 'vue-router' // Importante para ver las páginas
import Cabecera from '@/components/Cabecera.vue';
import PiePagina from './components/PiePagina.vue';
import AuthModal from '@/components/AuthModal.vue';

// Variable para mostrar u ocultar el modal
const mostrarModal = ref(false);
</script>

<template>
  <Cabecera @abrirModal="mostrarModal = true" />
    <div>
      

      <RouterView />
      
      
    </div>
  <PiePagina />

  <AuthModal 
    v-if="mostrarModal" 
    @close="mostrarModal = false"
  />
</template>

<style>

</style>