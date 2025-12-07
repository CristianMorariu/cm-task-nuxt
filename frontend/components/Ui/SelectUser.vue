<script setup lang="ts">
import { computed, ref } from "vue";

type Option = { id: number; username: string; avatar_url?: string };

const props = defineProps<{
  modelValue?: number | null;
  label?: string;
  options: any[];
  placeholder?: string;
}>();

const emit = defineEmits<{
  (e: "update:modelValue", v: number | null): void;
}>();

const q = ref("");
const filtered = computed(() =>
  props.options.filter((o) => {
    return o.username.toLowerCase().includes(q.value.toLowerCase());
  })
);

function select(id: number) {
  emit("update:modelValue", id);
}
</script>

<template>
  <div>
    <span v-if="label" class="block mb-1 text-sm font-medium text-slate-600">{{
      label
    }}</span>
    <div class="flex items-center gap-3">
      <div class="flex-1">
        <div class="relative">
          <input
            v-model="q"
            type="text"
            :placeholder="placeholder ?? 'Search'"
            class="w-full rounded-full border border-slate-200 bg-white/90 px-10 py-3 text-slate-700 placeholder:text-slate-400 outline-none focus:border-sky-300 focus:ring-2 focus:ring-sky-200"
          />
          <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"
            >🔍</span
          >
        </div>
        <div
          v-if="q"
          class="mt-2 max-h-44 overflow-auto rounded-xl border border-slate-200 bg-white shadow-sm"
        >
          <button
            v-for="o in filtered"
            :key="o.id"
            @click="select(o.id)"
            class="flex w-full items-center gap-3 px-3 py-2 text-left hover:bg-slate-50"
          >
            <img
              v-if="o.avatar_url"
              :src="o.avatar_url"
              class="h-6 w-6 rounded-full object-cover"
              alt=""
            />
            <span class="text-slate-700">{{ o.username }}</span>
          </button>
          <div v-if="!filtered.length" class="px-3 py-2 text-slate-400 text-sm">
            No results
          </div>
        </div>
      </div>

      <!-- Selected preview -->
      <div
        v-if="modelValue"
        class="flex items-center gap-2 rounded-full bg-white/90 px-3 py-1.5 border border-slate-200"
      >
        <img
          v-if="options.find((o) => o.id === modelValue)?.avatar_url"
          :src="options.find(o=>o.id===modelValue)!.avatar_url"
          class="h-7 w-7 rounded-full object-cover"
          alt=""
        />
        <span class="text-slate-700 text-sm">{{
          options.find((o) => o.id === modelValue)?.username
        }}</span>
      </div>
    </div>
  </div>
</template>
