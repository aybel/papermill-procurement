<template>
  <div class="login-container">
    <div class="login-card">
      <p class="system-name">Papermill Procurement</p>
      <h1 class="login-title">Iniciar Sesión</h1>
      <p class="login-subtitle">Bienvenido de nuevo</p>
      <form @submit.prevent="handleLogin">
        <div class="input-group">
          <label for="email">Correo Electrónico</label>
          <input
            type="email"
            id="email"
            v-model="email"
            required
            placeholder="tu@email.com" />
        </div>
        <div class="input-group">
          <label for="password">Contraseña</label>
          <input
            type="password"
            id="password"
            v-model="password"
            required
            placeholder="••••••••" />
        </div>
        <div v-if="error" class="error-message">
          {{ error }}
        </div>
        <button type="submit" :disabled="loading" class="login-button">
          <span v-if="loading">Cargando...</span>
          <span v-else>Entrar</span>
        </button>
      </form>

      <div class="register-link">
        <p>
          ¿No tienes una cuenta?
          <router-link to="/auth/register">Regístrate</router-link>
        </p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore } from "@/stores/authStore";

const email = ref("");
const password = ref("");
const loading = ref(false);
const error = ref<string | null>(null);

const authStore = useAuthStore();
const router = useRouter();
const handleLogin = async () => {
  loading.value = true;
  error.value = null;
  try {
    const loginSuccess = await authStore.login(email.value, password.value);
    if (loginSuccess) {
      // Redirigir al dashboard o a la página de inicio
      router.push("/home");
    }
  } catch (err: any) {
    // Manejo de errores para el usuario
    if (err.response && err.response.status === 401) {
      error.value = "Las credenciales son incorrectas.";
    } else {
      error.value =
        "Ocurrió un error inesperado. Por favor, inténtalo de nuevo.";
    }
  } finally {
    loading.value = false;
  }
};
</script>

<style scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f3f4f6;
}

.login-card {
  background: white;
  padding: 2.5rem;
  border-radius: 0.5rem;
  box-shadow:
    0 10px 15px -3px rgba(0, 0, 0, 0.1),
    0 4px 6px -2px rgba(0, 0, 0, 0.05);
  width: 100%;
  max-width: 24rem;
}

.system-name {
  text-align: center;
  font-weight: 700;
  color: #111827;
  margin-bottom: 0.75rem;
}

.login-title {
  font-size: 1.875rem;
  font-weight: bold;
  text-align: center;
  color: #1f2937;
}

.login-subtitle {
  margin-top: 0.5rem;
  text-align: center;
  color: #6b7280;
}

form {
  margin-top: 1.5rem;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.input-group {
  display: flex;
  flex-direction: column;
}

.input-group label {
  margin-bottom: 0.5rem;
  font-weight: 500;
  color: #374151;
}

.input-group input {
  padding: 0.75rem;
  border: 1px solid #d1d5db;
  border-radius: 0.375rem;
  width: 100%;
}

.input-group input:focus {
  outline: none;
  border-color: #4f46e5;
  box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.3);
}

.error-message {
  color: #ef4444;
  background-color: #fee2e2;
  padding: 0.75rem;
  border-radius: 0.375rem;
  text-align: center;
}

.login-button {
  padding: 0.75rem;
  border: none;
  border-radius: 0.375rem;
  background-color: #4f46e5;
  color: white;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.2s;
}

.login-button:hover {
  background-color: #4338ca;
}

.login-button:disabled {
  background-color: #a5b4fc;
  cursor: not-allowed;
}

.register-link {
  margin-top: 1.5rem;
  text-align: center;
  color: #6b7280;
}

.register-link a {
  color: #4f46e5;
  font-weight: 500;
  text-decoration: none;
}

.register-link a:hover {
  text-decoration: underline;
}
</style>
