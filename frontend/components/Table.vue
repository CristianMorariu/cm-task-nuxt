<script setup>
const props = defineProps({
  data: { type: Array, required: true }
})
</script>

<template>
  <table class="w-full text-sm text-left rtl:text-right text-gray-400">
    <thead class="text-xs uppercase bg-gray-700 text-gray-400">
      <tr>
        <slot name="thead" />
      </tr>
    </thead>
    <tbody>
      <tr v-for="(row, index) in data" :key="index" class="border-b bg-gray-800 border-gray-700 even:bg-gray-600">
        <!-- Pass row as slot prop -->
        <slot name="row" :row="row" />
      </tr>
    </tbody>
  </table>
</template>
