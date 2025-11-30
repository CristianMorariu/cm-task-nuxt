<script setup>
const { $api } = useNuxtApp();
const myTasks = ref();

onMounted(async () => {
  try {
    const resp = await $api.get("/api/my-tasks");
    myTasks.value = resp.data;
    console.log(myTasks.value);
  } catch (error) {
    console.log(error);
  }
});
</script>

<template>
  <div>My tasks</div>
</template>

<style scoped></style>
