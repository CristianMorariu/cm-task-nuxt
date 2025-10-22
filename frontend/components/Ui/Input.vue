<script setup lang="ts">
const props = withDefaults(
  defineProps<{
    modelValue?: string;
    label?: string;
    placeholder?: string;
    type?: string;
  }>(),
  { type: "text" }
);
const emit = defineEmits<{ (e: "update:modelValue", v: string): void }>();
</script>

<template>
  <label class="block">
    <span v-if="label" class="block mb-1 text-sm font-medium text-slate-600">{{
      label
    }}</span>
    <input
      :type="type"
      :value="modelValue"
      :placeholder="placeholder"
      @input="
        emit('update:modelValue', ($event.target as HTMLInputElement).value)
      "
      class="w-full rounded-full border h-[45px] border-slate-200 bg-white/90 px-5 py-2 text-slate-700 placeholder:text-slate-400 outline-none focus:border-sky-300 focus:ring-2 focus:ring-sky-200 hover:border-slate-400"
    />
  </label>
</template>
