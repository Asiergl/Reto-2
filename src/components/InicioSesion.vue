<!-- components/InicioSesion.vue -->
<template>
  <div class="min-h-screen bg-gradient-to-b from-gray-900 to-black text-white p-4 md:p-8">
    <!-- Contenedor principal -->
    <div class="max-w-6xl mx-auto">
      <!-- Título y filtros -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-center mb-2">Eventos Disponibles</h1>
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
          <div class="flex items-center gap-2">
            <span class="text-gray-300">Todos los tipos</span>
            <span class="text-gray-300">dd/mm/aaaa</span>
          </div>
          <div class="text-xl font-semibold text-green-400">EVERYONE WELCOME!</div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      
        <!-- Columna derecha - Formulario de inicio de sesión -->
        <div class="lg:col-span-1">
          <div class="bg-gray-800 rounded-lg p-6 sticky top-6">
            <h2 class="text-2xl font-bold mb-6 text-center">Torna</h2>
            
            <form @submit.prevent="handleLogin" class="space-y-6">
              <div>
                <label class="block text-gray-400 mb-2">Fecha:</label>
                <input 
                  type="date" 
                  v-model="loginData.date"
                  class="w-full bg-gray-700 border border-gray-600 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
              
              <div>
                <label class="block text-gray-400 mb-2">Hora:</label>
                <input 
                  type="time" 
                  v-model="loginData.time"
                  class="w-full bg-gray-700 border border-gray-600 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
              
              <div>
                <label class="block text-gray-400 mb-2">Plazas:</label>
                <input 
                  type="number" 
                  v-model="loginData.places"
                  class="w-full bg-gray-700 border border-gray-600 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
              </div>
              
              <div>
                <label class="block text-gray-400 mb-2">Contraseña:</label>
                <input 
                  type="password" 
                  v-model="loginData.password"
                  class="w-full bg-gray-700 border border-gray-600 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                  placeholder="Ingresa tu contraseña"
                />
              </div>
              
              <button 
                type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 rounded-md font-bold text-lg transition-colors"
              >
                Iniciar sesión
              </button>
            </form>
            
            <div class="mt-6 text-center">
              <p class="text-gray-300">
                ¿Aún no tienes cuenta? 
                <a href="#" class="text-blue-400 hover:text-blue-300 font-medium ml-1">¡Regístrate!</a>
              </p>
            </div>
          </div>
        </div>
      </div>

   
    
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const loginData = ref({
  date: '',
  time: '',
  places: '',
  password: ''
})

const handleLogin = () => {
  console.log('Datos de login:', loginData.value)
  alert('Inicio de sesión simulado - Datos enviados')
}
</script>

<style scoped>
input[type="date"]::-webkit-calendar-picker-indicator,
input[type="time"]::-webkit-calendar-picker-indicator {
  filter: invert(1);
  cursor: pointer;
}
</style>