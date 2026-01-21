<script setup>
import Footer from '@/components/Footer.vue';
import Cabecera from '@/components/Cabecera.vue';
</script>

<template>
 <Cabecera />
  <div class="juegos">
    <h1>Juegos Disponibles</h1>
    <p>Explora nuestra colección de juegos</p>
  </div>
  <Footer />
</template>



<style scoped>
.juegos {
  padding: 2rem;
  min-height: 400px;
}
</style>