export default defineNuxtRouteMiddleware(async (to) => {
  const publicNames = new Set(["auth-login", "auth-register"]);

  const { tried, ensureUser, isAuthenticated } = useAuth();
  console.log(tried.value);
  if (!tried.value) {
    await ensureUser();
  }

  if (publicNames.has(String(to.name))) {
    if (isAuthenticated.value) {
      return navigateTo({ name: "index" }, { replace: true });
    }
    return;
  }
  // 3) Dacă e rută protejată:
  if (!isAuthenticated.value) {
    return navigateTo(
      { name: "auth-login", query: { redirect: to.fullPath } },
      { replace: true }
    );
  }
});
