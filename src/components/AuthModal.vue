<template>
  <div v-if="visible" class="fixed inset-0 z-50 flex items-center justify-center bg-black/70">
    <div class="bg-white text-gray-800 rounded-xl shadow-2xl w-full max-w-sm p-6 relative">

      <!-- Cerrar modal -->
      <button @click="cerrar" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">✕</button>

      <!-- Título -->
      <h2 class="text-2xl font-bold mb-4 text-center">
        {{ modoRegistro ? 'Registrarse' : 'Iniciar sesión' }}
      </h2>

      <!-- Formulario según modo -->
      <LoginForm v-if="!modoRegistro" @success="cerrar" />
      <RegisterForm v-else @success="cerrar" />

      <!-- Link alternar login/registro -->
      <p class="text-sm text-center mt-4">
        {{ modoRegistro ? '¿Ya tienes cuenta?' : '¿Aún no tienes cuenta?' }}
        <button @click="toggleModo" class="text-purple-600 hover:underline ml-1">
          {{ modoRegistro ? 'Iniciar sesión' : 'Registrarse' }}
        </button>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref, defineProps, defineEmits } from 'vue'
import LoginForm from './LoginForm.vue'
import RegisterForm from './RegisterForm.vue'

const props = defineProps({
  visible: Boolean
})

const emit = defineEmits(['update:visible'])

const modoRegistro = ref(false)

const cerrar = () => {
  emit('update:visible', false)
  modoRegistro.value = false
}

const toggleModo = () => {
  modoRegistro.value = !modoRegistro.value
}
</script>
