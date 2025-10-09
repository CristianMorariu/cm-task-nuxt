export default defineNuxtRouteMiddleware((to) => {
  const { isAuthenticated } = useAuth();

  // whitelist pentru rute publice
  const publicNames = new Set(["auth-login", "auth-register"]);

  if (!isAuthenticated.value && !publicNames.has(String(to.name))) {
    return navigateTo({ name: "auth-login", query: { redirect: to.fullPath } });
  }
});
