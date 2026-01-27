<script setup>
import { ref, onMounted, watch } from 'vue';

const juegos = ref([]);
const juegoSeleccionado = ref(null);
const cargandoLista = ref(false);

// Filtros para la búsqueda combinada
const filtroTitulo = ref('');
const filtroGenero = ref('');
const filtroPlataforma = ref('');

const API_URL = 'http://localhost/Backend_reto-2/index.php';
const getImageUrl = (imgName) => `src/assets/games/${imgName}`;

// Función de carga que envía los 3 filtros al backend
const cargarJuegos = async () => {
  cargandoLista.value = true;
  try {
    const url = `${API_URL}?url=games&s=${encodeURIComponent(filtroTitulo.value)}&g=${encodeURIComponent(filtroGenero.value)}&p=${encodeURIComponent(filtroPlataforma.value)}`;
    const response = await fetch(url);
    if (!response.ok) throw new Error('Error al conectar con el servidor');
    juegos.value = await response.json();
  } catch (error) {
    console.error("Error:", error);
  } finally {
    cargandoLista.value = false;
  }
};

// Carga inicial
onMounted(() => cargarJuegos());

// Escuchar cambios en cualquiera de los tres filtros
watch([filtroTitulo, filtroGenero, filtroPlataforma], () => {
  cargarJuegos();
});

// Lógica de detalles: Busca en la lista local (como en tu ejemplo)
const verDetalles = (id) => {
  const juego = juegos.value.find(j => j.id === id);
  if (juego) {
    juegoSeleccionado.value = juego;
  }
};
</script>

<template>
  <div class="bg-gray-900 min-h-screen p-8 text-white relative">
    <div class="max-w-7xl mx-auto">
      <h1 class="text-4xl font-bold mb-6 text-pink-500">Catálogo de Juegos</h1>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <input
          v-model="filtroTitulo"
          type="text"
          placeholder="Buscar por título..."
          class="p-3 rounded-lg bg-gray-800 border border-gray-700 text-white focus:outline-none focus:border-pink-500"
        >
        <select v-model="filtroGenero" class="p-3 rounded-lg bg-gray-800 border border-gray-700 text-white focus:outline-none focus:border-pink-500">
          <option value="">Cualquier Género</option>
          <option value="RPG">RPG</option>
          <option value="Acción">Acción</option>
          <option value="Shooter">Shooter</option>
          <option value="Sandbox">Sandbox</option>
          <option value="Battle Royale">Battle Royale</option>
          <option value="MOBA">MOBA</option>
        </select>
        <select v-model="filtroPlataforma" class="p-3 rounded-lg bg-gray-800 border border-gray-700 text-white focus:outline-none focus:border-pink-500">
          <option value="">Cualquier Plataforma</option>
          <option value="PC">PC</option>
          <option value="Consola">Consola</option>
          <option value="Móviles">Móviles</option>
        </select>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="juego in juegos"
          :key="juego.id"
          class="bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-pink-500/20 transition-all duration-300 group"
        >
          <div class="h-48 overflow-hidden">
            <img :src="getImageUrl(juego.imagen)" :alt="juego.titulo" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
          </div>

          <div class="p-6">
            <div class="flex justify-between items-start mb-2">
              <h2 class="text-xl font-bold">{{ juego.titulo }}</h2>
              <span class="text-xs bg-pink-600 px-2 py-1 rounded text-white">{{ juego.genero }}</span>
            </div>

            <p class="text-gray-400 text-sm line-clamp-3 mb-4">
              {{ juego.descripcion }}
            </p>

            <button
              @click="verDetalles(juego.id)"
              class="w-full border border-pink-500 text-pink-500 py-2 rounded hover:bg-pink-500 hover:text-white transition-colors"
            >
              Ver Detalles
            </button>
          </div>
        </div>
      </div>

      <div v-if="juegos.length === 0 && !cargandoLista" class="text-center py-20">
        <p class="text-gray-500 text-xl">No se encontraron juegos con esos filtros.</p>
      </div>
    </div>

    <div v-if="juegoSeleccionado" class="fixed inset-0 z-50 flex items-center justify-center p-4">
      <div class="absolute inset-0 bg-black/80 backdrop-blur-sm" @click="juegoSeleccionado = null"></div>

      <div class="bg-gray-800 w-full max-w-2xl rounded-2xl overflow-hidden shadow-2xl z-10 border border-gray-700">
        <div class="relative h-64 md:h-80">
          <img :src="getImageUrl(juegoSeleccionado.imagen)" :alt="juegoSeleccionado.titulo" class="w-full h-full object-cover">
          <button @click="juegoSeleccionado = null" class="absolute top-4 right-4 bg-black/50 hover:bg-pink-500 text-white w-10 h-10 rounded-full flex items-center justify-center">✕</button>
        </div>

        <div class="p-8 space-y-4">
          <h2 class="text-3xl font-bold text-pink-500 mb-6 border-b border-gray-700 pb-2">{{ juegoSeleccionado.titulo }}</h2>

          <div class="flex items-center gap-2">
            <span class="font-bold text-pink-500 w-28 shrink-0">GÉNERO:</span>
            <span class="text-gray-300">{{ juegoSeleccionado.genero }}</span>
          </div>

          <div class="flex items-start gap-2">
            <span class="font-bold text-pink-500 w-28 shrink-0 mt-1">DESCRIPCIÓN:</span>
            <p class="text-gray-300 italic">{{ juegoSeleccionado.descripcion }}</p>
          </div>

          <div v-if="juegoSeleccionado.plataformas?.length" class="flex items-start gap-2">
            <span class="font-bold text-pink-500 w-28 shrink-0">PLATAFORMAS:</span>
            <div class="flex flex-wrap gap-2">
              <span v-for="(plat, index) in juegoSeleccionado.plataformas" :key="index" class="bg-pink-600/20 text-pink-400 border border-pink-500/30 px-3 py-1 rounded-lg text-sm">
                {{ plat }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
