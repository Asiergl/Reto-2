<script setup>
import { ref, reactive } from 'vue';

// Definir eventos que se envian al padre (App.vue)
// CORREGIDO: 'login-success' con doble s al final
const emit = defineEmits(['close', 'login-success']);

// Estado para saber si mostramos registro o login
const isLoginMode = ref(true); // true = login, false = registro
const errorMsg = ref('');
const successMsg = ref('');

// Datos del formulario
const form = reactive({
    username: '',
    email: '',
    password: ''
});

// URL de tu backend
const API_URL = 'http://localhost/Backend_reto-2';

// Funcion para cambiar de modo
const toggleMode = () => {
    isLoginMode.value = !isLoginMode.value;
    errorMsg.value = '';
    successMsg.value = '';
    // Limpiar campos
    form.username = '';
    form.email = '';
    form.password = '';
};

// Funcion principal de envio
const handleSubmit = async () => {
    errorMsg.value = '';
    successMsg.value = '';

    const endpoint = isLoginMode.value ? '/auth/login' : '/auth/register';

    try {
        const response = await fetch(`${API_URL}${endpoint}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include', // Importante para las cookies de sesion
            body: JSON.stringify(form)
        });

        const data = await response.json();

        if (response.ok) {
            if (isLoginMode.value) {
                // Login exitoso
                emit('login-success', data); // CORREGIDO el nombre del evento
                emit('close'); // cerrar el modal
            } else {
                // Registro exitoso
                successMsg.value = '¡Cuenta creada! Ahora inicia sesión.';
                // Cambiamos automáticamente a la vista de login tras registrarse
                setTimeout(() => {
                    isLoginMode.value = true;
                    successMsg.value = '';
                }, 1500);
            }
        } else {
            errorMsg.value = data.error || 'Ocurrió un error';
        }
    } catch (e) {
        errorMsg.value = 'Error de conexión con el servidor';
        console.error(e);
    }
};
</script>

<template>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    
        <div class="bg-gray-800 w-full max-w-md rounded-2xl shadow-2xl border border-gray-700 relative overflow-hidden animate-fade-in-up">
          
            <button 
                @click="$emit('close')" 
                class="absolute top-4 right-4 text-gray-400 hover:text-white transition-colors"
            >
                <span class="text-xl font-bold">✕</span>
            </button>

            <div class="bg-linear-to-r from-pink-600 to-purple-600 p-6 text-center">
                <h2 class="text-2xl font-bold text-white tracking-wide">
                    {{ isLoginMode ? 'Bienvenido de nuevo' : 'Únete a GameFest' }}
                </h2>
                <p class="text-pink-100 text-sm mt-1">
                    {{ isLoginMode ? 'Accede a tu cuenta para gestionar eventos' : 'Crea tu cuenta en segundos' }}
                </p>
            </div>

            <div class="p-8">
                
                <div v-if="errorMsg" class="mb-4 p-3 bg-red-500/20 border border-red-500 rounded text-red-200 text-sm text-center">
                    {{ errorMsg }}
                </div>
                <div v-if="successMsg" class="mb-4 p-3 bg-green-500/20 border border-green-500 rounded text-green-200 text-sm text-center">
                    {{ successMsg }}
                </div>

                <form @submit.prevent="handleSubmit" class="space-y-4">
                  
                    <div v-if="!isLoginMode">
                        <label class="block text-sm text-gray-400 mb-1">Nombre de usuario</label>
                        <input 
                            v-model="form.username" 
                            type="text" 
                            required
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-500 outline-none transition"
                            placeholder="Ej: Gamer123"
                        >
                    </div>

                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Correo Electrónico</label>
                        <input 
                            v-model="form.email" 
                            type="email" 
                            required
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-500 outline-none transition"
                            placeholder="tu@email.com"
                        >
                    </div>

                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Contraseña</label>
                        <input 
                            v-model="form.password" 
                            type="password" 
                            required
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:ring-2 focus:ring-pink-500 outline-none transition"
                            placeholder="••••••••"
                        >
                    </div>

                    <button 
                        type="submit" 
                        class="w-full bg-pink-600 hover:bg-pink-700 text-white font-bold py-2 rounded-lg transition-all transform hover:scale-[1.02] shadow-lg shadow-pink-600/30"
                    >
                        {{ isLoginMode ? 'Iniciar Sesión' : 'Registrarse' }}
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-gray-400">
                    <p v-if="isLoginMode">
                        ¿Aún no tienes cuenta? 
                        <button @click="toggleMode" class="text-pink-400 hover:text-pink-300 font-semibold hover:underline">
                            Regístrate gratis
                        </button>
                    </p>
                    <p v-else>
                        ¿Ya tienes cuenta? 
                        <button @click="toggleMode" class="text-pink-400 hover:text-pink-300 font-semibold hover:underline">
                            Inicia sesión
                        </button>
                    </p>
                </div>

            </div>
        </div>
    </div>
</template>

<style scoped>
.animate-fade-in-up {
    animation: fadeInUp 0.3s ease-out;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
