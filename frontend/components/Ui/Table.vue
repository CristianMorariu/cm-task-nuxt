<script setup>
import { computed, useSlots } from "vue";
// import { useDisplay } from "vuetify/lib/framework.mjs";
// import OptionsDots from "../Icons/OptionsDots.vue";

const slots = useSlots();
// const { smAndDown } = useDisplay();
const emit = defineEmits(["row-click"]);
const props = defineProps({
  data: { type: Array, required: true },
  loading: { type: Boolean, default: false },
  actions: { type: Array, required: false },
});

const columnCount = computed(() => {
  const theadVNodes = slots.thead ? slots.thead() : [];
  return theadVNodes.length;
});
</script>

<template>
  <div class="overflow-x-auto rounded-[12px] box-shadow">
    <table class="w-full table-auto text-sm text-left">
      <thead class="h-[56px]">
        <tr>
          <slot name="thead" />
        </tr>
        <tr>
          <td
            :colspan="columnCount"
            class="p-0 relative h-1 w-full overflow-hidden"
          >
            <hr />
            <div
              v-if="props.loading"
              class="absolute top-0 left-0 h-full w-1/2 bg-blue-500 animate-loading"
            ></div>
          </td>
        </tr>
      </thead>
      <tbody class="relative h-[56px]">
        <tr
          v-for="(row, index) in data"
          :key="index"
          class="h-[45px] hover:bg-gray-100 transition-colors duration-300 ease-out"
          @click="$emit('row-click', row)"
        >
          <!-- Pass row as slot prop -->
          <slot name="row" :row="row" />

          <!-- slot pentru actiuni pentru mai mult control in parinte -->
          <td
            v-if="$slots.actions"
            class="px-4 py-2 text-center actions-cell"
            @click.stop
          >
            <slot name="actions" :row="row" />
          </td>

          <!-- actiuni daca trimit props.actions -->
          <td class="px-4 py-2 text-center" v-if="props.actions" @click.stop>
            <!-- v-if="smAndDown" -->
            <!-- <v-menu offset-y close-on-content-click scroll-strategy="close">
              <template #activator="{ props }">
                <button v-bind="props" aria-label="Actions">
                  <v-icon size="auto"><OptionsDots /></v-icon>
                </button>
              </template>
              <div class="bg-white py-2 border box-shadow rounded-md mt-1">
                <div v-for="action in props.actions" :key="action.name">
                  <div
                    v-if="action.show && !action?.disabled"
                    class="px-4 py-2 cursor-pointer hover:bg-[var(--background-color)]"
                    @click="() => action.handler(row)"
                  >
                    <span>
                      {{ action.label }}
                    </span>
                  </div>
                </div>
              </div>
            </v-menu> -->
            <!-- <div v-else class="flex gap-3 justify-center">
              <div v-for="action in props.actions" :key="action.name">
                <v-tooltip
                  :text="action.label"
                  location="top"
                  open-delay="80"
                  close-delay="80"
                  :disabled="action?.disabled"
                >
                  <template #activator="{ props }">
                    <v-btn
                      v-bind="props"
                      size="small"
                      :color="action.color ?? 'primary'"
                      :icon="action.icon"
                      :key="action.name"
                      :disabled="action?.disabled"
                      @click.stop="() => action.handler(row)"
                    />
                  </template>
                </v-tooltip>
              </div>
            </div> -->
          </td>
        </tr>

        <tr v-if="props.data.length == 0 && !loading">
          <td :colspan="columnCount" class="text-center py-4 font-medium">
            Nu există date disponibile.
          </td>
        </tr>
        <div
          v-if="loading"
          class="absolute inset-0 bg-gray-50 bg-opacity-90 z-10 flex items-center justify-center pointer-events-auto"
        >
          <div class="inline-flex items-center space-x-2">
            <v-icon class="mdi-spin">mdi-loading</v-icon>
            <span class="font-medium">Se încarcă</span>
          </div>
        </div>
      </tbody>
      <tfoot v-if="props.data.length !== 0">
        <tr>
          <td :colspan="columnCount" :disabled="true">
            <slot name="pagination" />
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</template>
<style>
table > tbody > tr:nth-child(2n) {
  background-color: var(--background-color);
}
thead th {
  font-weight: bold;
  font-size: 0.9375rem; /* 15px */
}
</style>
