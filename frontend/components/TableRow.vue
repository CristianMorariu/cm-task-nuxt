<script setup>
const props = defineProps({
  data: { type: Array, required: true }
})
</script>

<template>
  <template v-for="(cell, i) in data" :key="i">
    <td class="px-4 py-2">{{ cell }}</td>
  </template>
</template>
