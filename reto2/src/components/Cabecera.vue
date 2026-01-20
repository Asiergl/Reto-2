<template>
  <footer class="gamefest-footer">
    <div class="container">

      <!-- Marca -->
      <router-link to="/" class="brand">
        <span class="brand-name">GameFest</span>
      </router-link>

      <!-- Navegación -->
      <nav class="footer-nav">
        <router-link to="/juegos" class="nav-link">Juegos</router-link>
        <router-link to="/eventos" class="nav-link">Eventos</router-link>
        <router-link to="/login" class="nav-link highlight">
          Iniciar sesión
        </router-link>
      </nav>

    </div>
  </footer>
</template>

<script setup>
// No se necesita lógica por ahora
</script>

<style scoped>
.gamefest-footer {
  background: linear-gradient(90deg, #d63384 0%, #4b1d3f 50%, #1a0b2e 100%);
  padding: 1rem 2rem;
  color: white;
  width: 100%;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* Marca */
.brand {
  text-decoration: none;
  display: flex;
  align-items: center;
  transition: opacity 0.3s;
}

.brand:hover {
  opacity: 0.8;
}

.brand-name {
  font-size: 1.2rem;
  font-weight: bold;
  color: white;
}

/* Navegación */
.footer-nav {
  display: flex;
  gap: 2rem;
}

.nav-link {
  color: white;
  text-decoration: none;
  font-weight: 600;
  font-size: 0.9rem;
  transition: color 0.3s;
}

.nav-link:hover {
  color: #ffb8d1;
}

.highlight {
  opacity: 0.9;
}

/* Responsive */
@media (max-width: 600px) {
  .container {
    flex-direction: column;
    gap: 1rem;
  }

  .footer-nav {
    gap: 1rem;
  }
}
</style>
