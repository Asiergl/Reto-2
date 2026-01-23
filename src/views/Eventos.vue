<script setup>
import { ref, onMounted, watch } from 'vue';

const eventos = ref([]);
const paginaActual = ref(1);
// Variable para controlar si hay más datos (simple)
const hayMasDatos = ref(true);

const API_URL = 'http://localhost/fran_cosas/Backend_reto-2'; 

// Función para cargar eventos según la página
const cargarEventos = async (pagina) => {
  try {
    const response = await fetch(`${API_URL}/events?page=${pagina}`);
    const data = await response.json();
    
    eventos.value = data;
    
    // Si devuelven menos de 9 eventos, es que no hay más páginas
    if (data.length < 9) {
      hayMasDatos.value = false;
    } else {
      hayMasDatos.value = true;
    }
  } catch (error) {
    console.error("Error cargando eventos:", error);
  }
};

// Cargar al inicio
onMounted(() => {
  cargarEventos(paginaActual.value);
});

// Funciones de paginación
const siguientePagina = () => {
  if (hayMasDatos.value) {
    paginaActual.value++;
    cargarEventos(paginaActual.value);
    // Scroll suave hacia arriba
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
};

const anteriorPagina = () => {
  if (paginaActual.value > 1) {
    paginaActual.value--;
    cargarEventos(paginaActual.value);
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }
};

// Helper para imágenes (asegúrate de tener las fotos en public/img/events)
const getImageUrl = (imgName) => {
  return `/src/assets/events/${imgName}`;
};

// Helper para formatear fecha (opcional, queda más bonito)
const formatearFecha = (fechaStr) => {
  const opciones = { day: 'numeric', month: 'long', year: 'numeric' };
  return new Date(fechaStr).toLocaleDateString('es-ES', opciones);
};
</script>

<template>
  <div class="bg-gray-900 min-h-screen p-8 text-white">
    <div class="max-w-7xl mx-auto">
      
      <div class="flex justify-between items-end mb-8">
        <div>
          <h1 class="text-4xl font-bold mb-2 text-pink-500">Agenda de Eventos</h1>
          <p class="text-gray-400">Página {{ paginaActual }}</p>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
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

      <div class="flex justify-center gap-4">
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
