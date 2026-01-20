<script setup>

import Cabecera from './components/Cabecera.vue';
import Footer from './components/Footer.vue';
</script>

<template>
  <header>
    <Cabecera />
  </header>
  <div class="app-container">
    <main class="main-content">
    
      

    </main>

    <!-- Footer global -->
    
  </div>
<footer>
      <Footer /> 
       </footer>
</template>

<style>
/* Layout base */
.app-container {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.main-content {
  flex: 1;
}
</style>
