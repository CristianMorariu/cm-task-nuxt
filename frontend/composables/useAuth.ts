type AuthUser = {
  id: number;
  username: string;
  abilities: string[];
  email: string;
};

export function useAuth() {
  const user = useState<AuthUser | null>("auth:user", () => null);
  const tried = useState<boolean>("auth:tried", () => false); // am încercat /api/me
  const isAuthenticated = computed(() => Boolean(user.value?.id));
  const { $api } = useNuxtApp();

  async function ensureUser() {
    if (import.meta.server) return user.value;
    if (tried.value) return user.value;
    tried.value = true;
    try {
      const { $api } = useNuxtApp();
      const me = await $api.get("/api/me");
      user.value = me.data.data ?? me.data;
    } catch (err) {
      // console.error("[/api/me] error:", err);
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
