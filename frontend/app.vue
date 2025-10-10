<script setup>
const auth = useAuth();

onMounted(() => {
  auth.hydrateFromStorage();
});
</script>

<template>
  <div>
    <NuxtLayout>
      <NuxtPage />
    </NuxtLayout>
  </div>
</template>
