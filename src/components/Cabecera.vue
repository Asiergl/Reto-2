<script setup>
// Recibimos el usuario como "prop" desde App.vue
defineProps({
  usuario: Object
});

// Definimos los eventos que emitimos hacia arriba
const emit = defineEmits(['abrirModal', 'cerrarSesion']);
</script>

<template>
  <header class="w-full py-4 px-8 text-white bg-[linear-gradient(90deg,#d63384_0%,#4b1d3f_50%,#1a0b2e_100%)] shadow-lg sticky top-0 z-40">
    
    <div class="container mx-auto grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-0 items-center">

      <router-link to="/" class="group flex items-center justify-self-center md:justify-self-start transition-opacity hover:opacity-80">
        <span class="text-xl font-bold tracking-wide">GameFest</span>
      </router-link>

      <nav class="justify-self-center md:justify-self-end">
        <div class="flex items-center gap-6 font-semibold text-sm sm:text-base">
          
          <router-link to="/juegos" class="hover:text-pink-300 transition-colors duration-300">
            Juegos
          </router-link>

          <router-link to="/eventos" class="hover:text-pink-300 transition-colors duration-300">
            Eventos
          </router-link>

          <div v-if="usuario" class="flex items-center gap-4 bg-black/20 px-4 py-1.5 rounded-full border border-white/10">
            <span class="text-pink-200">
              Hola, <span class="font-bold text-white">{{ usuario.username }}</span>
            </span>
            
            <button 
              @click="$emit('cerrarSesion')"
              class="text-xs bg-red-500/80 hover:bg-red-600 text-white px-3 py-1 rounded transition-colors"
              title="Cerrar sesión"
            >
              <i class="fas fa-sign-out-alt"></i> Salir
            </button>
          </div>

          <button 
            v-else
            @click="$emit('abrirModal')"
            class="bg-white/10 px-4 py-2 rounded-full hover:bg-white/20 hover:text-pink-200 transition-all duration-300 cursor-pointer border border-transparent hover:border-pink-300/30"
          >
            <i class="fas fa-user mr-2"></i> Iniciar sesión
          </button>

        </div>
      </nav>

    </div>
  </header>
</template>



<style scoped>
/* Ya no necesitamos estilos CSS aquí porque todo está controlado por Tailwind.
   Esto mantiene tu archivo limpio y fácil de mantener.
*/
</style>