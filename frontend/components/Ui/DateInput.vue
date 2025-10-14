<script setup lang="ts">
const props = defineProps<{ modelValue?: string; label?: string }>();
const emit = defineEmits<{ (e: "update:modelValue", v: string): void }>();
</script>

<template>
  <label class="block">
    <span v-if="label" class="block mb-1 text-sm font-medium text-slate-600">{{
      label
    }}</span>
    <div class="relative">
      <input
        type="date"
        :value="modelValue"
        @input="
          emit('update:modelValue', ($event.target as HTMLInputElement).value)
        "
        class="w-full rounded-full border border-slate-200 bg-white/90 px-5 py-3 text-slate-700 placeholder:text-slate-400 outline-none focus:border-sky-300 focus:ring-2 focus:ring-sky-200 [appearance:textfield]"
      />
      <span
        class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"
        >▾</span
      >
    </div>
  </label>
</template>
