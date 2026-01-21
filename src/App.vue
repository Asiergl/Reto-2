<script setup>
import { RouterView } from 'vue-router' // Importante para ver las páginas
import Cabecera from '@/components/Cabecera.vue';
import PiePagina from './components/PiePagina.vue';
</script>

<template>
  <Cabecera />
    <div>
      

      <RouterView />
      
      
    </div>
  <PiePagina />
</template>

<style>

</style>