<template>
  <header class="w-full py-4 px-8 text-white bg-[linear-gradient(90deg,#d63384_0%,#4b1d3f_50%,#1a0b2e_100%)] shadow-lg">
    
    <div class="container mx-auto grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-0 items-center">

      <router-link to="/" class="group flex items-center justify-self-center md:justify-self-start transition-opacity hover:opacity-80">
        <span class="text-xl font-bold tracking-wide">GameFest</span>
      </router-link>

      <nav class="justify-self-center md:justify-self-end">
        <div class="flex items-center gap-6 font-semibold text-sm sm:text-base">
          
          <router-link 
            to="/juegos" 
            class="hover:text-pink-300 transition-colors duration-300"
          >
            Juegos
          </router-link>

          <router-link 
            to="/eventos" 
            class="hover:text-pink-300 transition-colors duration-300"
          >
            Eventos
          </router-link>

          <router-link 
            to="/login" 
            class="bg-white/10 px-4 py-2 rounded-full hover:bg-white/20 hover:text-pink-200 transition-all duration-300"
          >
            Iniciar sesión
          </router-link>

        </div>
      </nav>

    </div>
  </header>
</template>

<script setup>
// Lógica del componente (vacía por ahora)
</script>

<style scoped>
/* Ya no necesitamos estilos CSS aquí porque todo está controlado por Tailwind.
   Esto mantiene tu archivo limpio y fácil de mantener.
*/
</style>