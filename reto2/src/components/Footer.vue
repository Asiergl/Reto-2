<template>
  <footer class="gamefest-footer">
    <div class="container">

      <!-- Columna 1: Logo y descripción -->
      <div class="footer-column">
        <div class="brand">
          <span class="brand-name">GameFest</span>
        </div>
        <p class="brand-description">
          Tu portal para descubrir videojuegos, eventos y mucho más.
          Únete a la comunidad de jugadores.
        </p>
      </div>

      <!-- Columna 2: Enlaces -->
      <div class="footer-column">
        <h3>Enlaces</h3>
        <ul class="footer-links">
          <li><router-link to="/">Inicio</router-link></li>
          <li><router-link to="/juegos">Juegos</router-link></li>
          <li><router-link to="/eventos">Eventos</router-link></li>
          <li><router-link to="/login">Iniciar sesión</router-link></li>
        </ul>
      </div>

      <!-- Columna 3: Redes sociales -->
      <div class="footer-column">
        <h3>Síguenos</h3>
        <div class="social-icons">
          <a href="#" target="_blank" aria-label="Facebook">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#" target="_blank" aria-label="Twitter">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#" target="_blank" aria-label="YouTube">
            <i class="fab fa-youtube"></i>
          </a>
        </div>
      </div>

    </div>

    <div class="footer-bottom">
      <p>© 2025 GameFest. Todos los derechos reservados.</p>
    </div>
  </footer>
</template>

<script setup>
// No necesita lógica por ahora
</script>

<style scoped>
.gamefest-footer {
  background: linear-gradient(90deg, #4b1d3f 0%, #d63384 100%);
  color: white;
  padding: 2rem 1rem 1rem 1rem;
  width: 100%;
  font-family: Arial, sans-serif;
}

.container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 2rem;
  max-width: 1200px;
  margin: 0 auto;
}

/* Columnas */
.footer-column {
  flex: 1 1 200px;
}

.brand {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 1rem;
}

.logo-img {
  width: 40px;
  height: 40px;
  border-radius: 8px;
}

.brand-name {
  font-weight: bold;
  font-size: 1.4rem;
}

.brand-description {
  font-size: 0.9rem;
  line-height: 1.4;
  margin-top: 0.5rem;
}

/* Enlaces */
.footer-links {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-links li {
  margin-bottom: 0.5rem;
}

.footer-links li a {
  color: white;
  text-decoration: none;
  transition: color 0.3s;
}

.footer-links li a:hover {
  color: #ffb8d1;
}

/* Redes sociales */
.social-icons {
  display: flex;
  gap: 1rem;
  font-size: 1.2rem;
}

.social-icons a {
  color: white;
  transition: color 0.3s;
}

.social-icons a:hover {
  color: #ffb8d1;
}

/* Footer inferior */
.footer-bottom {
  text-align: center;
  margin-top: 2rem;
  font-size: 0.8rem;
  border-top: 1px solid rgba(255,255,255,0.2);
  padding-top: 1rem;
}

/* Responsivo */
@media (max-width: 768px) {
  .container {
    flex-direction: column;
    gap: 1.5rem;
  }
  .footer-column {
    flex: 1 1 100%;
  }
}
</style>
