<script setup>
import Cabecera from '@/components/Cabecera.vue';
import Footer from '@/components/Footer.vue';
  
</script>

<template>
  <Cabecera />

  <div class="min-h-screen flex flex-col bg-gray-900 text-white font-sans">
    <main class="grow relative bg-[url('/img/fondo.png')] bg-cover bg-center bg-no-repeat flex items-center justify-center">
        
        <div class="bg-indigo-950/90 p-8 rounded-xl shadow-2xl max-w-md text-center">
          <h1 class="text-3xl font-bold mb-4">
            ¡Bienvenido a GameFest!
          </h1>

          <p class="text-gray-300 mb-6">
            Encuentra, organiza y participa en eventos de videojuegos y eSports.
          </p>

          <!-- Botones -->
          <div class="flex gap-4 justify-center">
            <RouterLink
              to="/juegos"
              class="bg-purple-600 hover:bg-purple-700 px-5 py-2 rounded-lg font-semibold transition"
            >
              Ver Juegos
            </RouterLink>

            <RouterLink
              to="/eventos"
              class="bg-pink-600 hover:bg-pink-700 px-5 py-2 rounded-lg font-semibold transition"
            >
              Ver Eventos
            </RouterLink>
          </div>
        </div>
        

    </main>

      

  </div>

    <Footer />
</template>