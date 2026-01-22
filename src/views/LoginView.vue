<template>
  <div class="min-h-screen flex flex-col bg-gray-900 text-white font-sans items-center justify-center">
    
    <!-- Modal siempre abierto en esta página -->
    <AuthModal v-model:visible="mostrarModal" />

    <!-- Fondo opcional -->
    <div class="absolute inset-0 bg-[url('/img/fondo.png')] bg-cover bg-center opacity-30"></div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import AuthModal from '@/components/AuthModal.vue'

const mostrarModal = ref(true) // <--- variable reactiva obligatoria para v-model
</script>
