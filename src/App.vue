<script setup>
import { RouterView } from 'vue-router'; // Importante para ver las páginas
import Cabecera from './components/Cabecera.vue';
import Footer from './components/Footer.vue';
</script>

<template>

  <Cabecera />
  
  <div class="min-h-screen flex flex-col bg-gray-900 text-white font-sans">
    
    

    <main class="flex-grow relative bg-[url('/img/fondo.png')] bg-cover bg-center bg-no-repeat">
      
      

    </main>

    

  </div>

  <Footer />
  
</template>

<style>
/* Ya no necesitamos CSS aquí, todo está controlado por Tailwind */
</style>