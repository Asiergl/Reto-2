<script setup>
import { RouterView } from 'vue-router' // Importante para ver las páginas
import Cabecera from '@/components/Cabecera.vue';
import Footer from '@/components/Footer.vue';
</script>

<template>
  <Cabecera />
  <div>
    

    <RouterView />
    
    
  </div>
  <Footer />
</template>

<style>

</style>