<script setup>
import { computed } from "vue";
import { RouterLink } from "vue-router";
import { useDisplay } from "vuetify/lib/framework.mjs";

const props = defineProps({
  items: { type: [Array, Object], default: () => [] },
  includeHome: { type: Boolean, default: true },
});

const { xs } = useDisplay();
const full = computed(() =>
  Array.isArray(props.items) ? props.items : props.items?.value || []
);
const homeCrumb = { text: "Acasă", to: { name: "home-view" } };

const isVisibleOnMobile = (i) =>
  // index 0 = Home, ultimele două = vizibile
  i === 0 || i >= full.value.length - 2;

const isLast = (i) => i === full.value.length - 1;
</script>

<template>
  <nav class="mb-5 max-w-full overflow-x-auto" aria-label="Breadcrumb">
    <ol class="flex items-center whitespace-nowrap text-sm">
      <li v-if="props.includeHome">
        <RouterLink :to="homeCrumb.to" class="truncate">
          <div class="flex gap-1">
            <svg
              class="min-w-5 min-h-5 w-5 h-5"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
              ></path>
            </svg>
            <span
              class="border-b-2 border-transparent hover:border-blue-500 hover:border-opacity-90 transition-all duration-200 ease-out truncate"
              v-if="!xs"
              >{{ homeCrumb.text }}</span
            >
          </div>
        </RouterLink>
      </li>
      <li
        v-for="(c, i) in full"
        :key="i"
        class="flex items-center min-w-0"
        :class="{
          'hidden sm:flex': full.length > 3 && !isVisibleOnMobile(i),
        }"
      >
        <span class="text-gray-400 flex min-w-4 min-h-4 w-5 h-5"
          ><svg
            fill="currentColor"
            viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
              clip-rule="evenodd"
            ></path></svg
        ></span>
        <RouterLink
          v-if="c.to && !isLast(i)"
          :to="c.to"
          class="border-b-2 border-transparent hover:border-blue-500 hover:border-opacity-90 transition-all duration-200 ease-out truncate"
        >
          {{ c.text }}
        </RouterLink>
        <span
          v-else
          class="mb-[2px] font-medium truncate"
          :aria-current="isLast(i) ? 'page' : undefined"
        >
          {{ c.text }}
        </span>
      </li>
    </ol>
  </nav>
</template>
