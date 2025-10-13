<script setup lang="ts">
const props = defineProps<{
  title?: string;
  description?: string;
  deadline?: string; // trimite deja formatat: ex. "22.04.2022"
  authorName?: string;
  authorAvatar?: string; // url img
}>();
</script>

<template>
  <article
    class="rounded-2xl border border-slate-200/80 bg-white/80 p-5 shadow-sm backdrop-blur hover:shadow md:transition-shadow"
  >
    <!-- header -->
    <header class="flex items-start justify-between gap-3">
      <h3 class="text-xl font-semibold text-slate-800">
        <slot name="title">{{ title }}</slot>
      </h3>

      <div class="flex items-center gap-2 text-slate-400">
        <!-- icons/actions din dreapta titlului -->
        <slot name="actions" />
      </div>
    </header>

    <!-- meta (deadline) -->
    <div v-if="deadline" class="mt-1">
      <span class="text-sm text-green-600 font-semibold">Deadline:</span>
      <span class="text-sm text-green-600"> {{ deadline }} </span>
    </div>

    <!-- description -->
    <p v-if="description || $slots.default" class="mt-2 text-slate-500 clamp-2">
      <slot>{{ description }}</slot>
    </p>

    <!-- footer -->
    <footer class="mt-4 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <img
          v-if="authorAvatar"
          :src="authorAvatar"
          alt=""
          class="h-8 w-8 rounded-full object-cover"
        />
        <span class="text-slate-700 font-medium">{{ authorName }}</span>
      </div>

      <div>
        <!-- default CTA -->
        <slot name="cta">
          <UiButton class="rounded-full px-4">DETAILS</UiButton>
        </slot>
      </div>
    </footer>
  </article>
</template>

<style scoped>
.clamp-2 {
  display: -webkit-box;
  line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
