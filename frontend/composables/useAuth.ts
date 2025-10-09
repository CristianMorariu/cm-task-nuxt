import axios from "@/axios";
import { useUser } from "@/composables/useUser";
import { useToken } from "@/composables/useToken";

export function useAuth() {
  const user = useUser();
  const token = useToken();

  const isAuthenticated = computed(() =>
    Boolean(user.value?.id && token.value)
  );

  /* Apelezi asta imediat după ce pornește aplicația (ex: în layout) */
  function hydrateFromStorage() {
    if (import.meta.client) {
      const t = localStorage.getItem("access_token");
      const u = localStorage.getItem("user");
      if (t) token.value = t;
      if (u) {
        try {
          user.value = JSON.parse(u);
        } catch {
          user.value = null;
        }
      }
    }
  }

  function login(response: { data: { data: any; token: string } }) {
    const payload = response.data;
    user.value = payload.data; // { id, username, email }
    token.value = payload.token;

    if (import.meta.client) {
      localStorage.setItem("access_token", payload.token);
      localStorage.setItem("user", JSON.stringify(payload.data));
    }
  }

  async function logout() {
    try {
      await axios.post("/logout", {});
    } catch (_) {
    } finally {
      forceLogout();
    }
  }

  /* Doar curăță local și redirecționează */
  function forceLogout() {
    user.value = null;
    token.value = null;
    if (import.meta.client) {
      localStorage.removeItem("access_token");
      localStorage.removeItem("user");
    }
  }

  return {
    user,
    token,
    isAuthenticated,
    hydrateFromStorage,
    login,
    logout,
    forceLogout,
  };
}
