<script setup>
import { ref, reactive } from 'vue';
import Swal from 'sweetalert2';
import { useRouter } from 'vue-router';

const router = useRouter();
const API_URL = 'http://localhost/fran_cosas/BackendReto-2';

// UX: Estado de carga
const cargando = ref(false);

const form = reactive({
  titulo: '',
  tipo: 'Torneo',
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

  // UX: Activar estado de carga
  cargando.value = true;

  try {
    const response = await fetch(`${API_URL}/events`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      credentials: 'include',
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
      router.push('/eventos');
    } else {
      Swal.fire('Error', data.error || 'No se pudo crear el evento', 'error');
    }
  } catch (error) {
    Swal.fire('Error', 'Fallo de conexión', 'error');
  } finally {
    // UX: Desactivar carga siempre
    cargando.value = false;
  }
};
</script>

<template>
  <main
    class="grow relative bg-[url('/img/fondoview.png')] bg-cover bg-center bg-no-repeat flex items-center justify-center min-h-screen">

    <div class="absolute inset-0 bg-gray-900/40"></div>

    <div class="relative z-10 p-8 text-white w-full max-w-4xl">
      <div class="bg-gray-800/90 backdrop-blur-md p-8 rounded-xl shadow-2xl border border-gray-700 animate-fade-in-up">

        <h1 class="text-3xl font-bold text-pink-500 mb-6 border-b border-gray-700 pb-4 drop-shadow-sm">
          Crear Nuevo Evento
        </h1>

        <form @submit.prevent="crearEvento" class="space-y-6 form-modern">

          <div>
            <label for="titulo" class="block text-gray-300 mb-2 font-medium">Título del Evento</label>
            <input id="titulo" v-model="form.titulo" type="text" required placeholder="Ej: Torneo de Valorant 2025"
              class="w-full bg-gray-900/50 border border-gray-600 rounded-lg p-3 focus:border-pink-500 focus:ring-1 focus:ring-pink-500 outline-none transition-all">
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="tipo" class="block text-gray-300 mb-2 font-medium">Tipo</label>
              <select id="tipo" v-model="form.tipo"
                class="w-full bg-gray-900/50 border border-gray-600 rounded-lg p-3 focus:border-pink-500 focus:ring-1 focus:ring-pink-500 outline-none transition-all cursor-pointer">
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
              <label for="plazas" class="block text-gray-300 mb-2 font-medium">Plazas Disponibles</label>
              <input id="plazas" v-model="form.plazasLibres" type="number" min="1"
                class="w-full bg-gray-900/50 border border-gray-600 rounded-lg p-3 focus:border-pink-500 focus:ring-1 focus:ring-pink-500 outline-none transition-all">
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="fecha" class="block text-gray-300 mb-2 font-medium">Fecha</label>
              <input id="fecha" v-model="form.fecha" type="date" required
                class="w-full bg-gray-900/50 border border-gray-600 rounded-lg p-3 focus:border-pink-500 focus:ring-1 focus:ring-pink-500 outline-none text-white cursor-pointer">
            </div>
            <div>
              <label for="hora" class="block text-gray-300 mb-2 font-medium">Hora</label>
              <input id="hora" v-model="form.hora" type="time" required
                class="w-full bg-gray-900/50 border border-gray-600 rounded-lg p-3 focus:border-pink-500 focus:ring-1 focus:ring-pink-500 outline-none text-white cursor-pointer">
            </div>
          </div>

          <div>
            <label for="imagen" class="block text-gray-300 mb-2 font-medium">Nombre de Imagen</label>
            <input id="imagen" v-model="form.imagen" type="text" placeholder="nombre_archivo.jpg"
              class="w-full bg-gray-900/50 border border-gray-600 rounded-lg p-3 focus:border-pink-500 focus:ring-1 focus:ring-pink-500 outline-none transition-all">
            <p class="text-xs text-gray-500 mt-1 italic">* La imagen debe estar en la carpeta /assets/events/ por
              defecto</p>
          </div>

          <div>
            <label for="descripcion" class="block text-gray-300 mb-2 font-medium">Descripción</label>
            <textarea id="descripcion" v-model="form.descripcion" rows="4"
              class="w-full bg-gray-900/50 border border-gray-600 rounded-lg p-3 focus:border-pink-500 focus:ring-1 focus:ring-pink-500 outline-none transition-all resize-none"
              placeholder="Describe de qué trata el evento..."></textarea>
          </div>

          <button type="submit" :disabled="cargando"
            class="w-full btn-submit text-white font-bold py-3 rounded-lg transition-all transform hover:scale-[1.01] shadow-lg flex justify-center items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed disabled:transform-none">
            <span v-if="cargando"
              class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
            <span>{{ cargando ? 'Publicando Evento...' : 'Publicar Evento' }}</span>
          </button>

        </form>
      </div>
    </div>
  </main>
</template>

<style scoped>
/* REQUISITO: Variables CSS y color-mix */
.form-modern {
  --color-input-border: #4b5563;
  /* gray-600 */
  --color-focus: #db2777;
  /* pink-600 */
}

.btn-submit {
  --btn-bg: #db2777;
  background-color: var(--btn-bg);
}

.btn-submit:hover:not(:disabled) {
  /* Oscurecemos el botón al hacer hover usando color-mix */
  background-color: color-mix(in srgb, var(--btn-bg), black 10%);
}

.animate-fade-in-up {
  animation: fadeInUp 0.4s ease-out;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>