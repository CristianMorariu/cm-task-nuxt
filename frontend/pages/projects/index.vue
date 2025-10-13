<script setup>
const { $api } = useNuxtApp();

onMounted(() => {
  try {
    const resp = $api.get("/api/projects");
    console.log(resp);
  } catch (_) {}
});
</script>
<template>
  <div>
    <h2>Projects</h2>
  </div>
</template>

<style scoped></style>
