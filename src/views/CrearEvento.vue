<script setup>
import { ref, reactive } from 'vue';
import Swal from 'sweetalert2';
import { useRouter } from 'vue-router';

const router = useRouter();
const API_URL = 'http://localhost/fran_cosas/BackendReto-2'; // Tu URL correcta

const form = reactive({
  titulo: '',
  tipo: 'Torneo', // Valor por defecto
  fecha: '',
  hora: '',
  plazasLibres: 10,
  imagen: '',
  descripcion: ''
});

const crearEvento = async () => {
  // Validación básica
  if (!form.titulo || !form.fecha || !form.hora) {
    Swal.fire('Error', 'Por favor rellena los campos obligatorios', 'error');
    return;
  }

  try {
    const response = await fetch(`${API_URL}/events`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'include', // IMPORTANTE para verificar que eres ADMIN
      body: JSON.stringify(form)
    });

    const data = await response.json();

    if (response.ok) {
      await Swal.fire({
        icon: 'success',
        title: 'Evento Creado',
        text: 'El evento se ha publicado correctamente',
        background: '#1f2937',
        color: '#fff',
        confirmButtonColor: '#db2777'
      });
      // Redirigir a la lista de eventos
      router.push('/eventos');
    } else {
      Swal.fire('Error', data.error || 'No se pudo crear el evento', 'error');
    }
  } catch (error) {
    Swal.fire('Error', 'Fallo de conexión', 'error');
  }
};
</script>

<template>
  <main class="grow relative bg-[url('/img/fondoview.png')] bg-cover bg-center bg-no-repeat flex items-center justify-center">
    <div class="p-8 text-white">
      <div class="max-w-3xl mx-auto bg-gray-800 p-8 rounded-xl shadow-2xl border border-gray-700">

        <h1 class="text-3xl font-bold text-pink-500 mb-6 border-b border-gray-700 pb-4">
          Crear Nuevo Evento
        </h1>

        <form @submit.prevent="crearEvento" class="space-y-6">

          <div>
            <label class="block text-gray-400 mb-2">Título del Evento</label>
            <input v-model="form.titulo" type="text" required
              class="w-full bg-gray-900 border border-gray-600 rounded p-3 focus:border-pink-500 outline-none">
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-gray-400 mb-2">Tipo</label>
              <select v-model="form.tipo"
                class="w-full bg-gray-900 border border-gray-600 rounded p-3 focus:border-pink-500 outline-none">
                <option>Presentación</option>
                <option>Charla</option>
                <option>Taller</option>
                <option>Mesa Redonda</option>
                <option>Exhibición</option>
                <option>Torneo</option>
                <option>Networking</option>
                <option>Competición</option>
              </select>
            </div>
            <div>
              <label class="block text-gray-400 mb-2">Plazas Disponibles</label>
              <input v-model="form.plazasLibres" type="number" min="1"
                class="w-full bg-gray-900 border border-gray-600 rounded p-3 focus:border-pink-500 outline-none">
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-gray-400 mb-2">Fecha</label>
              <input v-model="form.fecha" type="date" required
                class="w-full bg-gray-900 border border-gray-600 rounded p-3 focus:border-pink-500 outline-none text-white">
            </div>
            <div>
              <label class="block text-gray-400 mb-2">Hora</label>
              <input v-model="form.hora" type="time" required
                class="w-full bg-gray-900 border border-gray-600 rounded p-3 focus:border-pink-500 outline-none text-white">
            </div>
          </div>

          <div>
            <label class="block text-gray-400 mb-2">Nombre de Imagen (ej: torneo.jpg)</label>
            <input v-model="form.imagen" type="text" placeholder="nombre_archivo.jpg"
              class="w-full bg-gray-900 border border-gray-600 rounded p-3 focus:border-pink-500 outline-none">
            <p class="text-xs text-gray-500 mt-1">nombre de img/por fecto</p>
          </div>

          <div>
            <label class="block text-gray-400 mb-2">Descripción</label>
            <textarea v-model="form.descripcion" rows="4"
              class="w-full bg-gray-900 border border-gray-600 rounded p-3 focus:border-pink-500 outline-none"></textarea>
          </div>

          <button type="submit"
            class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-3 rounded-lg transition-transform transform hover:scale-[1.01]">
            Publicar Evento
          </button>

        </form>
      </div>
    </div>
  </main>
</template>