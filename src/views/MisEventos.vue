<script setup>
import { ref, onMounted } from 'vue';
import Swal from 'sweetalert2';

const misEventos = ref([]);
const cargando = ref(true);
const API_URL = 'http://localhost/fran_cosas/BackendReto-2';

// Cargar eventos del usuario
const cargarMisEventos = async () => {
  try {
    const response = await fetch(`${API_URL}/users/me/events`, {
        credentials: 'include' // Vital para que sepa quién eres
    });
    
    if (response.ok) {
        misEventos.value = await response.json();
    }
  } catch (error) {
    console.error(error);
  } finally {
    cargando.value = false;
  }
};

// Función Desapuntarse
const desapuntarse = async (evento) => {
    // Confirmación previa
    const result = await Swal.fire({
        title: '¿Estás seguro?',
        text: `Vas a liberar tu plaza en "${evento.titulo}"`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, desapuntarme',
        cancelButtonText: 'Cancelar',
        background: '#1f2937',
        color: '#fff'
    });

    if (!result.isConfirmed) return;

    try {
        const response = await fetch(`${API_URL}/events/${evento.id}/signup`, {
            method: 'DELETE', // Método DELETE para borrar
            credentials: 'include'
        });

        if (response.ok) {
            Swal.fire({
                icon: 'success',
                title: 'Hecho',
                text: 'Te has desapuntado correctamente',
                background: '#1f2937',
                color: '#fff',
                timer: 1500,
                showConfirmButton: false
            });
            // Recargamos la lista para que desaparezca
            cargarMisEventos();
        } else {
            throw new Error();
        }
    } catch (e) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo cancelar la inscripción',
            background: '#1f2937',
            color: '#fff'
        });
    }
};

onMounted(() => {
    cargarMisEventos();
});

const getImageUrl = (imgName) => `/src/assets/events/${imgName}`;
const formatearFecha = (fecha) => new Date(fecha).toLocaleDateString('es-ES');
</script>

<template>
  <div class="bg-gray-900 min-h-screen p-8 text-white">
    <div class="max-w-5xl mx-auto">
      <h1 class="text-3xl font-bold text-pink-500 mb-6 border-b border-gray-700 pb-4">
        Mis Inscripciones
      </h1>

      <div v-if="cargando" class="text-center text-gray-400 py-10">Cargando...</div>

      <div v-else-if="misEventos.length === 0" class="text-center py-20 bg-gray-800 rounded-xl border border-dashed border-gray-700">
        <p class="text-xl text-gray-400 mb-4">No estás apuntado a ningún evento aún.</p>
        <router-link to="/eventos" class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded-full font-bold transition">
            Ver Eventos Disponibles
        </router-link>
      </div>

      <div v-else class="space-y-4">
        <div v-for="evento in misEventos" :key="evento.id" 
             class="bg-gray-800 rounded-lg overflow-hidden flex flex-col md:flex-row shadow-lg border border-gray-700 hover:border-pink-500/50 transition">
            
            <div class="md:w-48 h-48 md:h-auto relative">
                <img :src="getImageUrl(evento.imagen)" class="w-full h-full object-cover">
            </div>

            <div class="p-6 flex-grow flex flex-col justify-center">
                <div class="flex justify-between items-start">
                    <h2 class="text-xl font-bold mb-2">{{ evento.titulo }}</h2>
                    <span class="bg-pink-900 text-pink-200 text-xs px-2 py-1 rounded">{{ evento.tipo }}</span>
                </div>
                
                <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ evento.descripcion }}</p>
                
                <div class="flex items-center gap-4 text-sm text-gray-300 mb-4">
                    <span><i class="fas fa-calendar"></i> {{ formatearFecha(evento.fecha) }}</span>
                    <span><i class="fas fa-clock"></i> {{ evento.hora.substring(0,5) }}</span>
                </div>

                <div class="mt-auto">
                    <button 
                        @click="desapuntarse(evento)"
                        class="text-red-400 border border-red-400 hover:bg-red-600 hover:text-white px-4 py-2 rounded text-sm font-bold transition-all flex items-center gap-2"
                    >
                        <i class="fas fa-trash-alt"></i> Cancelar Inscripción
                    </button>
                </div>
            </div>
        </div>
      </div>

    </div>
  </div>
</template>