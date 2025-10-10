<script setup>
import { watch, ref } from "vue";
import { useDebounce } from "@vueuse/core";
import Magnify from "../Icons/Magnify.vue";

const props = defineProps({
  modelValue: { type: String, default: "" },
  placeholder: { type: String, default: "Caută" },
  width: { type: String, default: "w-[336px]" },
});

const emit = defineEmits(["update:modelValue"]);
const inputValue = ref(props.modelValue);
const debounced = useDebounce(inputValue, 650);
// sync parent -> local
watch(
  () => props.modelValue,
  (val) => {
    inputValue.value = val;
  }
);
// Când se schimba debounced, emit update
watch(debounced, (val) => {
  emit("update:modelValue", val);
});
</script>

<template>
  <div
    :class="[width, 'min-w-[110px] box-shadow rounded-[12px] border relative']"
  >
    <input
      v-model="inputValue"
      type="text"
      :placeholder="placeholder"
      class="w-full h-11 p-4 rounded-[12px] outline-none"
    />
    <div class="absolute top-2 right-3">
      <v-icon v-if="!inputValue" class="opacity-60"><Magnify /></v-icon>
      <v-icon v-else class="opacity-80 cursor-pointer" @click="inputValue = ''"
        >mdi-close</v-icon
      >
    </div>
  </div>
</template>
