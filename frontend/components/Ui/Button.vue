<script setup>
import { cva } from "class-variance-authority";

const props = defineProps({
  leftIcon: Object,
  rightIcon: Object,
  loading: Boolean,
  disabled: Boolean,
  as: {
    type: [String, Object],
    default: "button",
  },
  intent: {
    type: String,
    validator: (val) =>
      ["primary", "secondary", "danger", "text"].includes(val),
    default: "primary",
  },
});

const buttonClass = computed(() => {
  return cva(
    "inline-flex items-center justify-center  text-sm min-h-[32px] px-3 py-0.5 font-semibold rounded-full",
    {
      variants: {
        intent: {
          primary: "bg-[#EFAC00] text-white hover:bg-[#C98321]",
          secondary:
            "bg-white  text-[#EFAC00] hover:bg-[#FFFDF2] border-2 border-[#EFAC00]",
          danger: "bg-red-600  text-white hover:bg-red-500",
          text: "text-gray-700 hover:bg-black/5",
        },
        disabled: {
          true: "!bg-[#E1E7EC] !text-[#8895A7] cursor-not-allowed",
        },
      },
    }
  )({ intent: props.intent, disabled: props.disabled });
});
</script>
<template>
  <component :is="props.as" :disabled="props.disabled" :class="buttonClass">
    <svg
      v-if="props.loading"
      class="size-5 animate-spin absolute"
      xmlns="http://www.w3.org/2000/svg"
      fill="none"
      viewBox="0 0 24 24"
    >
      <circle
        class="opacity-25"
        cx="12"
        cy="12"
        r="10"
        stroke="currentColor"
        stroke-width="4"
        data-darkreader-inline-stroke=""
        style="--darkreader-inline-stroke: currentColor"
      ></circle>
      <path
        class="opacity-75"
        fill="currentColor"
        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
        data-darkreader-inline-fill=""
        style="--darkreader-inline-fill: currentColor"
      ></path>
    </svg>
    <component
      :is="props.leftIcon"
      :class="['w-5 h-5 mr-2', props.loading && 'invisible']"
    />
    <span :class="[props.loading && 'invisible']"><slot /></span>
    <component
      v-if="!props.loading"
      :is="props.rightIcon"
      :class="['w-5 h-5 ml-2', props.loading && 'invisible']"
    />
  </component>
</template>

<style scoped></style>
