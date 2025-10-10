<script setup>
const props = defineProps({
  data: { type: Array, required: true },
  class: { type: String, required: false },
});
</script>

<template>
  <template v-for="(cell, i) in data" :key="i">
    <td
      class="px-4 py-2 text-wrap font-medium text-xs sm:text-sm"
      :class="props.class"
    >
      {{ cell }}
    </td>
  </template>
</template>
