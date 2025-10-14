<script setup lang="ts">
const props = defineProps<{
  modelValue?: string;
  label?: string;
  placeholder?: string;
  rows?: number;
}>();
const emit = defineEmits<{ (e: "update:modelValue", v: string): void }>();
</script>

<template>
  <label class="block">
    <span v-if="label" class="block mb-1 text-sm font-medium text-slate-600">{{
      label
    }}</span>
    <textarea
      :rows="rows ?? 5"
      :value="modelValue"
      :placeholder="placeholder"
      @input="
        emit('update:modelValue', ($event.target as HTMLTextAreaElement).value)
      "
      class="w-full rounded-2xl border border-slate-200 bg-white/90 px-5 py-3 text-slate-700 placeholder:text-slate-400 outline-none focus:border-sky-300 focus:ring-2 focus:ring-sky-200 resize-y"
    />
  </label>
</template>
