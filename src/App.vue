<script setup>
import { ref, onMounted } from 'vue';
import { RouterView } from 'vue-router' // Importante para ver las páginas
import Cabecera from '@/components/Cabecera.vue';
import PiePagina from './components/PiePagina.vue';
import AuthModal from '@/components/AuthModal.vue';

// Variable para mostrar u ocultar el modal
const mostrarModal = ref(false);

// Variable para guardar los datos del usuario
const usuario = ref(null);

// 1. Al cargar la app, miramos si hay sesión guardada en el navegador
onMounted(() => {
  const usuarioGuardado = localStorage.getItem('usuario_gamefest');
  if (usuarioGuardado) {
    usuario.value = JSON.parse(usuarioGuardado);
  }
});

// 2. Función que se ejecuta cuando el login es correcto (viene del Modal)
const alIniciarSesion = (datos) => {
  // Guardamos los datos útiles
  usuario.value = {
    username: datos.username, // Esto viene del PHP nuevo
    role: datos.role
  };
  // Lo guardamos en el navegador para que persista al recargar
  localStorage.setItem('usuario_gamefest', JSON.stringify(usuario.value));
};

// 3. Función para Cerrar Sesión (viene de la Cabecera)
const alCerrarSesion = async () => {
  // Llamamos al backend para destruir sesión PHP
  try {
    await fetch('http://localhost/fran_cosas/BackendReto-2/auth/logout', { 
        method: 'POST' 
    });
  } catch (e) {
    console.error("Error al cerrar sesión en servidor");
  }

  // Limpiamos el frontend
  usuario.value = null;
  localStorage.removeItem('usuario_gamefest');
};

</script>

<template>
  <Cabecera 
    :usuario="usuario"
    @abrirModal="mostrarModal = true" 
    @cerrarSesion="alCerrarSesion"
  />
    <div>
      

      <RouterView />
      
      
    </div>
  <PiePagina 
    :usuario="usuario"
    @abrirModal="mostrarModal = true"
  />

  <AuthModal 
    v-if="mostrarModal" 
    @close="mostrarModal = false"
    @login-success="alIniciarSesion"
  />
</template>

<style>

</style>