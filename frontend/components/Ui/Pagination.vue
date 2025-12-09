<script setup lang="ts">
import { computed } from "vue";

interface MetaLink {
  url: string | null;
  label: string;
  page: number | null;
  active: boolean;
}

interface Meta {
  current_page: number;
  last_page: number;
  from: number | null;
  to: number | null;
  total: number;
  per_page: number;
  links: MetaLink[];
}

const props = defineProps<{
  meta: Meta | null | undefined;
  loading?: boolean;
}>();

const emit = defineEmits<{
  (e: "change", page: number): void;
}>();

const currentPage = computed(() => props.meta?.current_page ?? 1);
const lastPage = computed(() => props.meta?.last_page ?? 1);

type PageItem = number | "dots";

const pageItems = computed<PageItem[]>(() => {
  const cp = currentPage.value;
  const lp = lastPage.value;
  if (!lp) return [];

  // puține pagini -> le arătăm pe toate
  if (lp <= 7) {
    return Array.from({ length: lp }, (_, i) => i + 1);
  }

  const items: PageItem[] = [];

  if (cp <= 3) {
    // aproape de început
    items.push(1, 2, 3, 4, "dots", lp);
  } else if (cp >= lp - 2) {
    // aproape de final
    items.push(1, "dots", lp - 3, lp - 2, lp - 1, lp);
  } else {
    // undeva la mijloc
    items.push(1, "dots", cp - 1, cp, cp + 1, "dots", lp);
  }

  return items;
});

const hasPrev = computed(() => currentPage.value > 1);
const hasNext = computed(() => currentPage.value < lastPage.value);

function goTo(page: number | null) {
  if (!page) return;
  if (page === currentPage.value) return;
  if (page < 1 || page > lastPage.value) return;
  if (props.loading) return;

  emit("change", page);
}
</script>

<template>
  <!-- nu afișăm nimic dacă nu avem meta sau e doar o singură pagină -->
  <div v-if="meta && lastPage > 1" class="w-full flex justify-center px-4 my-3">
    <nav class="inline-flex items-center gap-1 text-sm">
      <!-- Previous -->
      <button
        type="button"
        class="px-3 py-1 rounded-md border transition"
        :class="
          hasPrev && !loading
            ? 'bg-white text-gray-700 hover:bg-gray-50'
            : 'bg-gray-100 text-gray-400 cursor-not-allowed'
        "
        :disabled="!hasPrev || loading"
        @click="goTo(currentPage - 1)"
      >
        ‹
      </button>

      <!-- Page numbers -->
      <template v-for="(item, index) in pageItems" :key="index">
        <button
          v-if="item === 'dots'"
          type="button"
          class="px-3 py-1 rounded-md text-gray-400 cursor-default select-none"
          disabled
        >
          ...
        </button>

        <button
          v-else
          type="button"
          class="px-3 py-1 rounded-md border transition"
          :class="
            item === currentPage
              ? 'bg-blue-600 text-white border-blue-600'
              : 'bg-white text-gray-700 hover:bg-gray-50'
          "
          :disabled="loading"
          @click="goTo(item)"
        >
          {{ item }}
        </button>
      </template>

      <!-- Next -->
      <button
        type="button"
        class="px-3 py-1 rounded-md border transition"
        :class="
          hasNext && !loading
            ? 'bg-white text-gray-700 hover:bg-gray-50'
            : 'bg-gray-100 text-gray-400 cursor-not-allowed'
        "
        :disabled="!hasNext || loading"
        @click="goTo(currentPage + 1)"
      >
        ›
      </button>
    </nav>
  </div>
</template>
<style scoped></style>
