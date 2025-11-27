type AuthUser = { id: number; username: string; email: string };

export function useAuth() {
  const user = useState<AuthUser | null>("auth:user", () => null);
  const tried = useState<boolean>("auth:tried", () => false); // am încercat /api/me
  const isAuthenticated = computed(() => Boolean(user.value?.id));
  const { $api } = useNuxtApp();

  async function ensureUser() {
    // nu face nimic pe server (SSR)
    if (import.meta.server) return user.value;

    if (tried.value) return user.value;

    tried.value = true;

    try {
      const { $api } = useNuxtApp(); // instanța ta axios
      const me = await $api.get("/api/me"); // Authorization: Bearer <token> vine din interceptor

      console.log("USER USE AUTH", me.data);
      user.value = me.data.data ?? me.data;
    } catch (err) {
      console.error("[/api/me] error:", err);
      user.value = null;
    }

    return user.value;
  }

  async function logout() {
    try {
      await $api.post("/logout", {});
    } catch (_) {
    } finally {
      clearUser();
    }
  }
  function setUser(u: AuthUser | null) {
    console.log("setUser");
    user.value = u;
    tried.value = true;
  }
  function clearUser() {
    user.value = null;
    tried.value = true;
  }

  return {
    user,
    isAuthenticated,
    tried,
    ensureUser,
    setUser,
    logout,
    clearUser,
  };
}
