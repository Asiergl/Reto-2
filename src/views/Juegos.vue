<script setup>
import { ref, onMounted } from 'vue';

// Estado reactivo para guardar los juegos
const juegos = ref([]);

// URL de tu backend (Ajusta esto según donde tengas tu PHP corriendo)
// Si usas XAMPP suele ser localhost/nombre_carpeta
const API_URL = 'http://localhost/fran_cosas/BackendReto-2';

onMounted(async () => {
  try {
    // Llamamos al endpoint que definimos en index.php
    const response = await fetch(`${API_URL}/games`);
    if (!response.ok) throw new Error('Error al cargar juegos');

    const data = await response.json();
    juegos.value = data; // Guardamos los datos en la variable reactiva
  } catch (error) {
    console.error(error);
  }
});

// Función auxiliar para las imágenes (asumiendo que están en public/img o una ruta estática)
const getImageUrl = (imgName) => {
  // Ajusta esta ruta según donde guardes las imágenes del ZIP

  return `src/assets/games/${imgName}`;

};
</script>

<template>
  <div class="bg-gray-900 min-h-screen p-8 text-white">
    <div class="max-w-7xl mx-auto">
      <h1 class="text-4xl font-bold mb-2 text-pink-500">Catálogo de Juegos</h1>
      <p class="text-gray-400 mb-8">Explora los títulos disponibles en el festival</p>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        <div
          v-for="juego in juegos"
          :key="juego.id"
          class="bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-pink-500/20 transition-all duration-300 group"
        >
          <div class="h-48 overflow-hidden">
            <img
              :src="getImageUrl(juego.imagen)"
              :alt="juego.titulo"
              class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
            >
          </div>

          <div class="p-6">
            <div class="flex justify-between items-start mb-2">
              <h2 class="text-xl font-bold">{{ juego.titulo }}</h2>
              <span class="text-xs bg-pink-600 px-2 py-1 rounded text-white">{{ juego.genero }}</span>
            </div>

            <p class="text-gray-400 text-sm line-clamp-3 mb-4">
              {{ juego.descripcion }}
            </p>

            <button class="w-full border border-pink-500 text-pink-500 py-2 rounded hover:bg-pink-500 hover:text-white transition-colors">
              Ver Detalles
            </button>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>
