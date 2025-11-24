type AuthUser = { id: number; username: string; email: string };

export function useAuth() {
  const user = useState<AuthUser | null>("auth:user", () => null);
  const tried = useState<boolean>("auth:tried", () => false); // am încercat /api/me
  const isAuthenticated = computed(() => Boolean(user.value?.id));
  const { $api } = useNuxtApp();

  async function ensureUser() {
    // if (tried.value) return user.value;
    console.log("useAuth", tried.value);
    const headers = import.meta.server
      ? useRequestHeaders(["cookie"])
      : undefined;

    try {
      // const me = await $fetch(`${import.meta.env.VITE_API_BASE_URL}/api/me`, {
      //   credentials: "include",
      //   headers,
      // });
      // const me = await $api.get("/api/me", {
      //   withCredentials: true,
      //   headers,
      // });

      const me = await $fetch(`${import.meta.env.VITE_API_BASE_URL}/api/me`, {
        credentials: "include",
        headers: {
          ...headers,
          accept: "application/json",
        },
      });
      if (import.meta.server) console.log("[/api/me] server response:", me);
      console.log("USER USE AUTH", me);
      user.value = (me as any).data ?? me;
    } catch (err) {
      if (import.meta.server) console.error("[/api/me] server error:", err);
      user.value = null;
    } finally {
      tried.value = true;
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
