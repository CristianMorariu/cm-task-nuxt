<script setup>
const props = defineProps({
  data: { type: Array, required: true },
});
const slots = useSlots();
const columnCount = computed(() => {
  const theadVNodes = slots.thead ? slots.thead() : [];
  return theadVNodes.length;
});
</script>

<template>
  <div class="rounded-2xl overflow-hidden shadow-lg ring-1 ring-black/5">
    <table
      class="w-full border-separate border-spacing-0 text-left text-gray-700"
    >
      <thead class="text-sm font-semibold text-white">
        <tr class="h-14">
          <slot name="thead" />
        </tr>
      </thead>

      <tbody class="bg-white">
        <tr
          v-for="(row, idx) in data"
          :key="idx"
          class="border-b last:border-b-0 border-gray-200 hover:bg-gray-50"
        >
          <slot name="row" :row="row" />
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td :colspan="columnCount">
            <slot name="tfoot" />
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</template>
<style scoped>
thead {
  background: linear-gradient(90deg, #efac00 0%, #ff9500 50%);
}

table {
  border-collapse: separate;
  border-spacing: 0;
}

th,
td {
  padding: 14px 16px;
}

th {
  color: #fff;
}

thead th + th {
  border-left: 1px solid rgba(255, 255, 255, 0.15);
}

tbody td + td {
  border-left: 1px solid rgba(0, 0, 0, 0.04);
}
</style>
