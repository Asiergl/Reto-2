<script setup>
import { ref, onMounted, watch } from 'vue';

const eventos = ref([]);
const paginaActual = ref(1);
const hayMasDatos = ref(true);

// --- 1. NUEVAS VARIABLES REACTIVAS PARA EL BUSCADOR ---
const filtroTipo = ref('todos');
const filtroFecha = ref('');
const filtroSoloLibres = ref(false);

const API_URL = 'http://localhost/Backend_reto-2'; 

// --- 2. FUNCIÓN CARGAR EVENTOS (Ahora con filtros) ---
const cargarEventos = async () => {
  try {
    // Construimos los parámetros para el PHP
    const params = new URLSearchParams({
      page: paginaActual.value,
      tipo: filtroTipo.value,
      fecha: filtroFecha.value,
      soloLibres: filtroSoloLibres.value ? '1' : '0'
    });

    const response = await fetch(`${API_URL}/events?${params.toString()}`);
    const data = await response.json();
    
    eventos.value = data;
    
    // Si devuelven menos de 9 eventos, no hay más páginas
    hayMasDatos.value = data.length >= 9;
  } catch (error) {
    console.error("Error cargando eventos:", error);
  }
};

// --- 3. WATCHERS (Para buscar automáticamente al cambiar filtros) ---
watch([filtroTipo, filtroFecha, filtroSoloLibres], () => {
  paginaActual.value = 1; // Reiniciar a página 1 al filtrar
  cargarEventos();
});

onMounted(() => {
  cargarEventos();
});

const siguientePagina = () => {
  if (hayMasDatos.value) {
    paginaActual.value++;
    cargarEventos();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
};

const anteriorPagina = () => {
  if (paginaActual.value > 1) {
    paginaActual.value--;
    cargarEventos();
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
};

const getImageUrl = (imgName) => {
  return `/src/assets/events/${imgName}`;
};

const formatearFecha = (fechaStr) => {
  const opciones = { day: 'numeric', month: 'long', year: 'numeric' };
  return new Date(fechaStr).toLocaleDateString('es-ES', opciones);
};

// Función para limpiar filtros
const limpiarFiltros = () => {
  filtroTipo.value = 'todos';
  filtroFecha.value = '';
  filtroSoloLibres.value = false;
};
</script>

<template>
  <div class="bg-gray-900 min-h-screen p-8 text-white">
    <div class="max-w-7xl mx-auto">
      
      <div class="flex justify-between items-end mb-8">
        <div>
          <h1 class="text-4xl font-bold mb-2 text-pink-500">Agenda de Eventos</h1>
          <p class="text-gray-400">Explora los próximos eventos de GameFest</p>
        </div>
        <p class="text-gray-500 text-sm italic">Página {{ paginaActual }}</p>
      </div>

      <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 mb-10 flex flex-wrap gap-6 items-end">
        <div class="flex flex-col gap-2 flex-1 min-w-[200px]">
          <label class="text-xs font-bold uppercase text-pink-400 tracking-wider">Tipo de Evento</label>
          <select 
            v-model="filtroTipo"
            class="bg-gray-900 border border-gray-600 rounded-lg px-4 py-2.5 focus:outline-none focus:border-pink-500 transition-colors text-white"
          >
            <option value="todos">Todos los tipos</option>
            <option value="Presentación">Presentación</option>
            <option value="Charla">Charla</option>
            <option value="Taller">Taller</option>
            <option value="Mesa Redonda">Mesa Redonda</option>
            <option value="Exhibición">Exhibición</option>
            <option value="Torneo">Torneo</option>
            <option value="Networking">Networking</option>
            <option value="Competición">Competición</option>
          </select>
        </div>

        <div class="flex flex-col gap-2 flex-1 min-w-[200px]">
          <label class="text-xs font-bold uppercase text-pink-400 tracking-wider">Fecha</label>
          <input 
            type="date" 
            v-model="filtroFecha"
            class="bg-gray-900 border border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:border-pink-500 transition-colors text-white"
          >
        </div>

        <div class="flex items-center gap-3 mb-2.5">
          <input 
            type="checkbox" 
            id="libres" 
            v-model="filtroSoloLibres"
            class="w-5 h-5 accent-pink-500 cursor-pointer"
          >
          <label for="libres" class="cursor-pointer text-gray-300 select-none">Solo plazas libres</label>
        </div>

        <button 
          @click="limpiarFiltros"
          class="mb-1 px-4 py-2 text-sm text-gray-400 hover:text-pink-400 transition-colors"
        >
          Limpiar filtros
        </button>
      </div>

      <div v-if="eventos.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        <div 
          v-for="evento in eventos" 
          :key="evento.id"
          class="bg-gray-800 rounded-xl overflow-hidden shadow-lg border border-gray-700 hover:border-pink-500 transition-all duration-300 flex flex-col"
        >
          <div class="h-48 overflow-hidden relative">
            <img 
              :src="getImageUrl(evento.imagen)" 
              :alt="evento.titulo"
              class="w-full h-full object-cover"
            >
            <div class="absolute top-2 right-2 bg-black/70 px-3 py-1 rounded-full text-sm font-bold text-pink-400">
              {{ evento.tipo }}
            </div>
          </div>

          <div class="p-6 grow flex flex-col">
            <div class="mb-4">
              <h2 class="text-xl font-bold mb-2 line-clamp-1" :title="evento.titulo">{{ evento.titulo }}</h2>
              <div class="flex items-center gap-4 text-sm text-gray-300">
                <span><i class="fas fa-calendar mr-1"></i> {{ formatearFecha(evento.fecha) }}</span>
                <span><i class="fas fa-clock mr-1"></i> {{ evento.hora.substring(0, 5) }}</span>
              </div>
            </div>
            
            <p class="text-gray-400 text-sm line-clamp-2 mb-4 grow">
              {{ evento.descripcion }}
            </p>

            <div class="mt-auto pt-4 border-t border-gray-700 flex justify-between items-center">
              <span class="text-sm">
                Plazas: 
                <span :class="evento.plazasLibres > 0 ? 'text-green-400' : 'text-red-500'">
                  {{ evento.plazasLibres }}
                </span>
              </span>
              <button class="bg-pink-600 hover:bg-pink-700 px-4 py-2 rounded text-sm font-bold transition-colors">
                Inscribirse
              </button>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="text-center py-20 bg-gray-800 rounded-xl border border-dashed border-gray-600">
        <p class="text-gray-400 text-xl">No se encontraron eventos con esos filtros.</p>
        <button @click="limpiarFiltros" class="mt-4 text-pink-500 underline">Mostrar todos los eventos</button>
      </div>

      <div class="flex justify-center gap-4 mt-8">
        <button 
          @click="anteriorPagina" 
          :disabled="paginaActual === 1"
          class="px-6 py-2 rounded-full bg-gray-700 hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed transition"
        >
          &larr; Anterior
        </button>

        <button 
          @click="siguientePagina" 
          :disabled="!hayMasDatos"
          class="px-6 py-2 rounded-full bg-pink-600 hover:bg-pink-700 disabled:opacity-50 disabled:cursor-not-allowed transition"
        >
          Siguiente &rarr;
        </button>
      </div>

    </div>
  </div>
</template>