<script setup>
// Recibimos el usuario como "prop" desde App.vue
defineProps({
  usuario: Object
});

// Definimos los eventos que emitimos hacia arriba
const emit = defineEmits(['abrirModal', 'cerrarSesion']);
</script>

<template>
  <header
    class="w-full py-4 px-8 text-white bg-[linear-gradient(90deg,#d63384_0%,#4b1d3f_50%,#1a0b2e_100%)] shadow-lg sticky top-0 z-40">

    <div class="container mx-auto grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-0 items-center">

      <router-link to="/"
        class="group flex items-center justify-self-center md:justify-self-start transition-opacity hover:opacity-80">
        <span class="text-xl font-bold tracking-wide">GameFest</span>
      </router-link>

      <nav class="justify-self-center md:justify-self-end">
        <div class="flex items-center gap-6 font-semibold text-sm sm:text-base">

          <router-link to="/juegos" class=" font-semibold hover:text-pink-300 transition-colors duration-300">
            Juegos
          </router-link>

          <router-link to="/eventos" class=" font-semibold hover:text-pink-300 transition-colors duration-300">
            Eventos
          </router-link>

          <div v-if="usuario" class="flex items-center gap-4">

            <router-link v-if="usuario && usuario.role === 'ADMIN'" to="/crear-evento"
              class=" font-semibold hover:text-pink-300 transition-colors border-b-2 border-transparent hover:border-pink-300">
              Crear Evento
            </router-link>

            <router-link to="/mis-eventos"
              class=" font-semibold hover:text-pink-300 transition-colors border-b-2 border-transparent hover:border-pink-300">
              Mis Eventos
            </router-link>

            <div class="flex items-center gap-2 bg-black/20 px-4 py-1.5 rounded-full border border-white/10">
              <span class="text-pink-200 text-sm">
                Hola, <span class="font-bold text-white">{{ usuario.username }}</span>
              </span>

              <button @click="$emit('cerrarSesion')"
                class="ml-2 flex items-center justify-center bg-red-500/80 hover:bg-red-600 text-white w-6 h-6 rounded transition-colors"
                title="Cerrar sesión">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                  stroke="currentColor" class="w-3.5 h-3.5">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
              </button>
            </div>
          </div>

          <button v-else @click="$emit('abrirModal')"
            class="bg-white/10 px-4 py-2 rounded-full hover:bg-white/20 hover:text-pink-200 transition-all duration-300 cursor-pointer border border-transparent hover:border-pink-300/30 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
              stroke="currentColor" class="w-4 h-4">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
            </svg>
            Iniciar sesión
          </button>

        </div>
      </nav>

    </div>
  </header>
</template>

<style scoped></style>
