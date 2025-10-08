<script setup>
const route = useRoute();
const title = computed(() => route.meta.authTitle ?? "Welcome at");
</script>
<template>
  <div class="bg-img relative">
    <div
      class="container w-[500px] h-[700px] right-0 sm:right-20 md:right-40 lg:right-60 xl:right-80 top-0 sm:top-[160px]"
    >
      <h1 class="text-5xl flex justify-center">{{ title }}</h1>
      <div class="flex justify-between items-center pt-5">
        <hr class="w-24" />
        <img src="@/assets/Logo.png" alt="Logo" />
        <hr class="w-24" />
      </div>
      <slot />
    </div>
  </div>
</template>

<style scoped>
.bg-img {
  background-image: url(~/assets/shadow.png), url(~/assets/bg4.png);
  height: 100vh;
  width: 100%;
  background-position: center, center;
  background-repeat: no-repeat, no-repeat;
  background-size: cover, cover;
}
.container {
  position: absolute;
  background-color: white;
  border-radius: 5px;
  padding: 3rem 2rem;
}
</style>
