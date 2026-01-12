import { defineStore } from "pinia";
import apiClient from "@/plugins/axios";

// Definimos los tipos para el estado del usuario
interface User {
  id: number;
  name: string;
  email: string;
  // ...otros campos que puedas tener
}

interface AuthState {
  user: User | null;
  token: string | null;
  roles: string[];
  permissions: string[];
  returnUrl: string | null;
}


export const useAuthStore = defineStore("auth", {
  state: (): AuthState => ({
    // Intentamos obtener el estado inicial desde localStorage para persistir la sesión
    user: JSON.parse(localStorage.getItem("user") || "null"),
    token: localStorage.getItem("token") || null,
    roles: JSON.parse(localStorage.getItem("roles") || "[]"),
    permissions: JSON.parse(localStorage.getItem("permissions") || "[]"),
    returnUrl: null,
  }),
  getters: {
    isAuthenticated: (state) => !!state.token,
    hasPermission: (state) => (permission: string) =>
      state.permissions.includes(permission),
  },
  actions: {
    async login(email: string, password: string) {
      try {
        const response = await apiClient.post("v1/auth/login", {
          email,
          password,
        });
        const { access_token } = response.data;

        // Guardar el token en el estado y en localStorage
        this.token = access_token;
        localStorage.setItem("token", access_token);

        // Después de obtener el token, obtenemos los datos del usuario
        await this.fetchUser();

        // Redirigir al usuario a la página que intentaba visitar o al dashboard
        return true;
      } catch (error) {
        console.error("Error en el login:", error);
        // Aquí podrías manejar el error, por ejemplo, mostrando una notificación
        throw error;
      }
    },

    async fetchUser() {
      if (this.token) {
        try {
          const response = await apiClient.get("v1/auth/me");
          const { user, roles, permissions } = response.data;

          // Guardar los datos del usuario en el estado y en localStorage
          this.user = user;
          this.roles = roles;
          this.permissions = permissions;

          localStorage.setItem("user", JSON.stringify(user));
          localStorage.setItem("roles", JSON.stringify(roles));
          localStorage.setItem("permissions", JSON.stringify(permissions));
        } catch (error) {
          console.error("Error fetching user:", error);
          // Si hay un error (ej. token inválido), limpiamos la sesión
          this.logout();
        }
      }
    },

    logout() {
      // Limpiar el estado
      this.user = null;
      this.token = null;
      this.roles = [];
      this.permissions = [];

      // Limpiar localStorage
      localStorage.removeItem("user");
      localStorage.removeItem("token");
      localStorage.removeItem("roles");
      localStorage.removeItem("permissions");

      // Redirigir a la página de login
      window.location.href = '/';
    },
  },
});
