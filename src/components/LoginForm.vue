<template>
  <form @submit.prevent="login" class="space-y-4">
    <div>
      <label class="block text-sm font-medium mb-1">Correo Electrónico</label>
      <input
        v-model="correo"
        type="email"
        placeholder="Correo electrónico"
        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
        required
      />
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Contraseña</label>
      <input
        v-model="contrasena"
        type="password"
        placeholder="Contraseña"
        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
        required
      />
    </div>

    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 rounded-lg font-semibold transition">
      Iniciar sesión
    </button>
  </form>
</template>

<script setup>
import { ref, defineEmits } from 'vue'

const emit = defineEmits(['success'])

const correo = ref('')
const contrasena = ref('')

const login = () => {
  if(correo.value && contrasena.value){
    alert(`Login\nCorreo: ${correo.value}\nContraseña: ${contrasena.value}`)
    correo.value = ''
    contrasena.value = ''
    emit('success') 
  } else {
    alert('Completa todos los campos')
  }
}
</script>
