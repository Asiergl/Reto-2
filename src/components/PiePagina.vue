<template>
  <footer class="w-full py-8 px-4 text-white bg-[linear-gradient(90deg,#4b1d3f_0%,#d63384_100%)]">
    
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">

      <div class="flex flex-col gap-4">
        <div class="flex items-center gap-2">
          <span class="text-2xl font-bold tracking-wide">GameFest</span>
        </div>
        <p class="text-sm leading-relaxed text-gray-100 opacity-90">
          Tu portal para descubrir videojuegos, eventos y mucho más.
          Únete a la comunidad de jugadores.
        </p>
      </div>

      <div>
        <h3 class="text-lg font-bold mb-4 uppercase tracking-wider">Enlaces</h3>
        <ul class="grid grid-cols-2 gap-y-2 gap-x-4 text-sm">
          <li>
            <router-link to="/" class="hover:text-pink-300 transition-colors duration-300">
              Inicio
            </router-link>
          </li>
          <li>
            <router-link to="/juegos" class="hover:text-pink-300 transition-colors duration-300">
              Juegos
            </router-link>
          </li>
          <li>
            <router-link to="/eventos" class="hover:text-pink-300 transition-colors duration-300">
              Eventos
            </router-link>
          </li>
          <li>
            <router-link to="/login" class="hover:text-pink-300 transition-colors duration-300">
              Iniciar sesión
            </router-link>
          </li>
        </ul>
      </div>

      <div>
        <h3 class="text-lg font-bold mb-4 uppercase tracking-wider">Síguenos</h3>
        <div class="flex gap-4 text-xl">
          <a href="#" target="_blank" aria-label="Facebook" class="hover:text-pink-300 hover:scale-110 transition-all duration-300">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#" target="_blank" aria-label="Twitter" class="hover:text-pink-300 hover:scale-110 transition-all duration-300">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#" target="_blank" aria-label="YouTube" class="hover:text-pink-300 hover:scale-110 transition-all duration-300">
            <i class="fab fa-youtube"></i>
          </a>
        </div>
      </div>

    </div>

    <div class="mt-8 pt-4 border-t border-white/20 text-center text-sm text-gray-200">
      <p>© 2025 GameFest. Todos los derechos reservados.</p>
    </div>

  </footer>
</template>

<script setup>
// Sin lógica necesaria
</script>

<style scoped>
/* Estilos eliminados a favor de Tailwind */
</style>
