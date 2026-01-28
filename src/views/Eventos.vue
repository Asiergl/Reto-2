<script setup>
import { ref, onMounted, watch } from 'vue';
// IMPORTAMOS SWEETALERT2
import Swal from 'sweetalert2';

const eventos = ref([]);
const paginaActual = ref(1);
const hayMasDatos = ref(true);

// Variable para el Modal de Detalle
const eventoSeleccionado = ref(null);

// Filtros
const filtroTipo = ref('todos');
const filtroFecha = ref('');
const filtroSoloLibres = ref(false);

const API_URL = 'http://localhost/fran_cosas/BackendReto-2';

// --- FUNCIÓN CARGAR EVENTOS ---
const cargarEventos = async () => {
  try {
    const params = new URLSearchParams({
      page: paginaActual.value,
      tipo: filtroTipo.value,
      fecha: filtroFecha.value,
      soloLibres: filtroSoloLibres.value ? '1' : '0'
    });

    const response = await fetch(`${API_URL}/events?${params.toString()}`);
    if (!response.ok) throw new Error("Error en la petición");

    const data = await response.json();
    eventos.value = data;
    hayMasDatos.value = data.length >= 9;

  } catch (error) {
    console.error("Error cargando eventos:", error);
  }
};

// --- WATCHERS ---
watch([filtroTipo, filtroFecha, filtroSoloLibres], () => {
  paginaActual.value = 1;
  cargarEventos();
});

onMounted(() => {
  cargarEventos();
});

// --- PAGINACIÓN ---
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

// --- HELPERS (CORREGIDO IMÁGENES) ---
const getImageUrl = (imgName) => {
  try {
    return new URL(`/src/assets/events/${imgName}`, import.meta.url).href;
  } catch (e) {
    return '';
  }
};

const formatearFecha = (fechaStr) => {
  const opciones = { day: 'numeric', month: 'long', year: 'numeric' };
  return new Date(fechaStr).toLocaleDateString('es-ES', opciones);
};

const limpiarFiltros = () => {
  filtroTipo.value = 'todos';
  filtroFecha.value = '';
  filtroSoloLibres.value = false;
};

// --- ABRIR MODAL ---
const abrirModal = (evento) => {
  eventoSeleccionado.value = evento;
};

// --- INSCRIPCIÓN ---
const toggleInscripcion = async (evento) => {
  const usuarioLocal = localStorage.getItem('usuario_gamefest');

  if (!usuarioLocal) {
    Swal.fire({
      icon: 'warning',
      title: 'Acceso denegado',
      text: 'Debes iniciar sesión para apuntarte a los eventos.',
      background: '#1f2937', color: '#fff', confirmButtonColor: '#db2777'
    });
    return;
  }

  try {
    const response = await fetch(`${API_URL}/events/${evento.id}/signup`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'include'
    });

    const data = await response.json();

    if (response.ok) {
      Swal.fire({
        icon: 'success',
        title: '¡Inscrito!',
        text: 'Te has apuntado al evento correctamente.',
        background: '#1f2937', color: '#fff', confirmButtonColor: '#db2777',
        timer: 2000, showConfirmButton: false
      });

      // Actualizamos visualmente la tarjeta y el modal (si está abierto)
      evento.plazasLibres--;

    } else {
      Swal.fire({
        icon: 'error',
        title: 'Ups...',
        text: data.error || "Ocurrió un error al inscribirte",
        background: '#1f2937', color: '#fff', confirmButtonColor: '#db2777'
      });
    }

  } catch (error) {
    Swal.fire({
      icon: 'error',
      title: 'Error de conexión',
      text: 'No se pudo conectar con el servidor',
      background: '#1f2937', color: '#fff'
    });
  }
};
</script>

<template>
  <main
    class="grow relative bg-[url('/img/fondoview.png')] bg-cover bg-center bg-no-repeat flex items-center justify-center">
    <div class="min-h-screen text-white">
      <div class="max-w-7xl mx-auto">

        <div class="flex justify-between items-end mb-8 mt-8">
          <div>
            <h1 class="text-4xl font-bold mb-2 text-pink-500">Agenda de Eventos</h1>
            <p class="text-gray-400">Explora los próximos eventos de GameFest</p>
          </div>
          <p class="text-gray-500 text-sm italic">Página {{ paginaActual }}</p>
        </div>

        <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 mb-10 flex flex-wrap gap-6 items-end">
          <div class="flex flex-col gap-2 flex-1 min-w-50">
            <label class="text-xs font-bold uppercase text-pink-400 tracking-wider">Tipo de Evento</label>
            <select v-model="filtroTipo"
              class="bg-gray-900 border border-gray-600 rounded-lg px-4 py-2.5 focus:outline-none focus:border-pink-500 transition-colors text-white">
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

          <div class="flex flex-col gap-2 flex-1 min-w-50">
            <label class="text-xs font-bold uppercase text-pink-400 tracking-wider">Fecha</label>
            <input type="date" v-model="filtroFecha"
              class="bg-gray-900 border border-gray-600 rounded-lg px-4 py-2 focus:outline-none focus:border-pink-500 transition-colors text-white">
          </div>

          <div class="flex items-center gap-3 mb-2.5">
            <input type="checkbox" id="libres" v-model="filtroSoloLibres"
              class="w-5 h-5 accent-pink-500 cursor-pointer">
            <label for="libres" class="cursor-pointer text-gray-300 select-none">Solo plazas libres</label>
          </div>

          <button @click="limpiarFiltros"
            class="mb-1 px-4 py-2 text-sm text-gray-400 hover:text-pink-400 transition-colors">
            Limpiar filtros
          </button>
        </div>

        <div v-if="eventos.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
          <div v-for="evento in eventos" :key="evento.id"
            class="bg-gray-800 rounded-xl overflow-hidden shadow-lg border border-gray-700 hover:border-pink-500 transition-all duration-300 flex flex-col group">
            <div class="h-48 overflow-hidden relative cursor-pointer" @click="abrirModal(evento)">
              <img :src="getImageUrl(evento.imagen)" :alt="evento.titulo"
                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
              <div class="absolute top-2 right-2 bg-black/70 px-3 py-1 rounded-full text-sm font-bold text-pink-400">
                {{ evento.tipo }}
              </div>
              <div
                class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                <span
                  class="text-white font-bold border border-white px-4 py-1 rounded-full bg-black/50 backdrop-blur-sm">Ver
                  Detalles</span>
              </div>
            </div>

            <div class="p-6 grow flex flex-col">
              <div class="mb-4">
                <h2 class="text-xl font-bold mb-2 line-clamp-1 hover:text-pink-400 cursor-pointer transition-colors"
                  @click="abrirModal(evento)">
                  {{ evento.titulo }}
                </h2>
                <div class="flex items-center gap-4 text-sm text-gray-300">
                  <span><i class="fas fa-calendar mr-1"></i> {{ formatearFecha(evento.fecha) }}</span>
                  <span><i class="fas fa-clock mr-1"></i> {{ evento.hora.substring(0, 5) }}</span>
                </div>
              </div>

              <p class="text-gray-400 text-sm line-clamp-2 mb-4 h-10 overflow-hidden">
                {{ evento.descripcion }}
              </p>

              <div class="mt-auto pt-4 border-t border-gray-700 flex justify-between items-center">
                <span class="text-sm">
                  Plazas:
                  <span :class="evento.plazasLibres > 0 ? 'text-green-400' : 'text-red-500'">
                    {{ evento.plazasLibres }}
                  </span>
                </span>
                <button @click="toggleInscripcion(evento)" :disabled="evento.plazasLibres === 0"
                  :class="evento.plazasLibres === 0 ? 'bg-gray-600 cursor-not-allowed' : 'bg-pink-600 hover:bg-pink-700'"
                  class="px-4 py-2 rounded text-sm font-bold transition-colors text-white">
                  {{ evento.plazasLibres === 0 ? 'Agotado' : 'Inscribirse' }}
                </button>
              </div>
            </div>
          </div>
        </div>

        <div v-else class="text-center py-20 bg-gray-800 rounded-xl border border-dashed border-gray-600">
          <p class="text-gray-400 text-xl">No se encontraron eventos con esos filtros.</p>
          <button @click="limpiarFiltros" class="mt-4 text-pink-500 underline">Mostrar todos los eventos</button>
        </div>

        <div class="flex justify-center gap-4 mt-8 mb-8">
          <button @click="anteriorPagina" :disabled="paginaActual === 1"
            class="px-6 py-2 rounded-full bg-gray-700 hover:bg-gray-600 disabled:opacity-50 disabled:cursor-not-allowed transition">
            &larr; Anterior
          </button>
          <button @click="siguientePagina" :disabled="!hayMasDatos"
            class="px-6 py-2 rounded-full bg-pink-600 hover:bg-pink-700 disabled:opacity-50 disabled:cursor-not-allowed transition">
            Siguiente &rarr;
          </button>
        </div>

      </div>

      <div v-if="eventoSeleccionado" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/90 backdrop-blur-sm" @click="eventoSeleccionado = null"></div>

        <div
          class="bg-gray-800 w-full max-w-2xl rounded-2xl overflow-hidden shadow-2xl z-10 border border-gray-600 relative transition-all duration-300 transform scale-100 opacity-100">

          <button @click="eventoSeleccionado = null"
            class="absolute top-4 right-4 z-20 bg-black/60 hover:bg-pink-600 text-white w-10 h-10 rounded-full flex items-center justify-center transition-colors text-xl font-bold">
            ✕
          </button>

          <div class="relative h-64 md:h-72">
            <img :src="getImageUrl(eventoSeleccionado.imagen)" :alt="eventoSeleccionado.titulo"
              class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-linear-to-t from-gray-900 to-transparent"></div>
            <div class="absolute bottom-4 left-6 right-6">
              <span class="inline-block bg-pink-600 text-white text-xs font-bold px-2 py-1 rounded mb-2">{{
                eventoSeleccionado.tipo }}</span>
              <h2 class="text-3xl font-bold text-white drop-shadow-lg leading-tight">{{ eventoSeleccionado.titulo }}
              </h2>
            </div>
          </div>

          <div class="p-8 space-y-6">

            <div class="flex flex-wrap gap-6 text-sm text-gray-300 border-b border-gray-700 pb-4">
              <div class="flex items-center gap-2">
                <i class="fas fa-calendar text-pink-500"></i>
                <span class="font-semibold text-white">{{ formatearFecha(eventoSeleccionado.fecha) }}</span>
              </div>
              <div class="flex items-center gap-2">
                <i class="fas fa-clock text-pink-500"></i>
                <span class="font-semibold text-white">{{ eventoSeleccionado.hora.substring(0, 5) }}</span>
              </div>
              <div class="flex items-center gap-2 ml-auto">
                <i class="fas fa-users text-pink-500"></i>
                <span>Plazas libres: <span class="font-bold text-green-400">{{ eventoSeleccionado.plazasLibres
                }}</span></span>
              </div>
            </div>

            <div>
              <span class="text-pink-500 font-bold tracking-wider text-sm block mb-2">DESCRIPCIÓN COMPLETA</span>
              <p class="text-gray-300 leading-relaxed text-lg">{{ eventoSeleccionado.descripcion }}</p>
            </div>

            <div class="pt-4">
              <button @click="toggleInscripcion(eventoSeleccionado)" :disabled="eventoSeleccionado.plazasLibres === 0"
                class="w-full py-3 rounded-lg font-bold text-white shadow-lg transition-transform hover:scale-[1.02] flex items-center justify-center gap-2"
                :class="eventoSeleccionado.plazasLibres === 0 ? 'bg-gray-600 cursor-not-allowed' : 'bg-linear-to-r from-pink-600 to-purple-600 hover:from-pink-500 hover:to-purple-500'">
                {{ eventoSeleccionado.plazasLibres === 0 ? 'AGOTADO' : 'INSCRIBIRSE AHORA' }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>