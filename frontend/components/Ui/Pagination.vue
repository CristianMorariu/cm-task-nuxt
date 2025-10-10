<script setup>
import { computed, ref, watch } from "vue";
import { useDisplay } from "vuetify";
import ItemsPerPage from "./ui/ItemsPerPage.vue";

const props = defineProps({
  meta: {
    type: Object,
    required: true,
  },
  loading: { type: Boolean, default: false },
});
const emit = defineEmits(["update:pagination"]);
// console.log(props.meta);
const { xs, sm, smAndDown } = useDisplay();
const totalVisible = computed(() => (xs.value ? 1 : 4));
const density = computed(() => (smAndDown.value ? "compact" : "default"));
const metaData = ref(props.meta);
watch(
  () => props.meta,
  (val) => {
    metaData.value = val;
  }
);

function updatePagination() {
  emit("update:pagination", metaData.value);
}
</script>

<template>
  <div
    class="flex flex-col sm:flex-row sm:justify-between sm:items-center px-4 my-3 gap-y-4 sm:gap-y-0 sm:gap-x-4"
  >
    <ItemsPerPage
      v-model="metaData.limit"
      :total-items-number="metaData.totalCount ?? 0"
      :loading="props.loading"
      @update:modelValue="updatePagination"
    />
    <v-pagination
      v-model="metaData.page"
      @update:modelValue="updatePagination"
      :length="metaData.totalPages"
      :total-visible="totalVisible"
      rounded="lg"
      :density="density"
      :disabled="props.loading"
    />
  </div>
</template>

<style scoped></style>
