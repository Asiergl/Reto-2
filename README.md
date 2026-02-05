[README.md](https://github.com/user-attachments/files/25109879/README.md)
# 🎮 GameFest - Frontend

Plataforma web para la gestión, visualización e inscripción a eventos de videojuegos y eSports.

## 📋 Descripción del Proyecto

En el servidor = http://10.0.56.66/~dw2t_francisco/ la web esta conectada a la base de datos http://10.0.56.66/phpmyadmin/index.php usuario: dw2t_francisco contraseña: 12345
para realizar pruebas. hay dos usuarios creados uno es admin = administrador@gmail.com y otro es user = manolo@gmail.com, la contraseña es: 12345 en ambos 

# Este Frontend esta orientado y con las API_URL apuntando al servidor, no a localhost = http://10.0.56.66/~dw2t_francisco/backend 

Este proyecto es el **Frontend** de la aplicación GameFest, desarrollado con **Vue 3** y **Vite**. Se comunica con un Backend en PHP/MySQL para gestionar usuarios, juegos y eventos.

### Características Principales
* **Catálogo de Juegos:** Búsqueda filtrada por título, género y plataforma.
* **Gestión de Eventos:** Visualización de agenda, plazas disponibles y detalles.
* **Sistema de Usuarios:** Registro e inicio de sesión (Login/Logout).
* **Inscripciones:** Los usuarios pueden apuntarse y desapuntarse de eventos.
* **Panel de Administración:** Creación de nuevos eventos con subida de imágenes (Solo Admin).
* **Diseño Responsivo:** Adaptado a móviles y escritorio con CSS moderno (`color-mix`, variables CSS).

## 🛠️ Tecnologías

* [Vue.js 3](https://vuejs.org/) - Framework JavaScript (Composition API).
* [Vite](https://vitejs.dev/) - Entorno de desarrollo y empaquetador.
* [Vue Router](https://router.vuejs.org/) - Enrutamiento SPA (Single Page Application).
* [SweetAlert2](https://sweetalert2.github.io/) - Alertas modales atractivas.
* **CSS Moderno** - Uso de `var()` y `color-mix` para temización.

## 🚀 Instalación y Configuración

### Prerrequisitos
* Node.js (v16 o superior)
* NPM

### Pasos para desarrollo local

1.  **Clonar el repositorio:**
    ```bash
    git clone <URL_DEL_REPOSITORIO>
    cd FrontendReto-2
    ```

2.  **Instalar dependencias:**
    ```bash
    npm install
    ```

3.  **Configurar la API (Importante):**
    Si estás trabajando en local con Docker o XAMPP, ve a los archivos `.vue` (como `App.vue`, `Eventos.vue`, etc.) y asegúrate de que la variable `API_URL` apunta a tu local:
    ```javascript
    // Para Docker Local
    const API_URL = 'http://localhost:8080/backend';
    ```

4.  **Ejecutar servidor de desarrollo:**
    ```bash
    npm run dev
    ```

## 📦 Despliegue en Servidor (Nemesio)

Para subir la aplicación al servidor de producción (`/~dw2t_francisco/`), sigue estos pasos estrictos:

1.  **Configurar Rutas de Producción:**
    * Asegúrate de que en todos los archivos `.vue`, `API_URL` apunta al servidor real:
        `const API_URL = 'http://10.0.56.66/~dw2t_francisco/backend';`
    * Verifica que `vite.config.js` tiene `base: '/~dw2t_francisco/'`.
    * Verifica que `router/index.js` tiene `history: createWebHistory('/~dw2t_francisco/')`.

2.  **Compilar el proyecto:**
    Genera la carpeta `dist` optimizada:
    ```bash
    npm run build
    ```

3.  **Subir archivos (FTP/FileZilla):**
    * Sube **todo el contenido** de la carpeta `dist` generada a la carpeta `public_html` del servidor.
    * **IMPORTANTE:** Asegúrate de subir también el archivo `.htaccess` que está en la carpeta `public` para evitar errores 404 al recargar la página.
