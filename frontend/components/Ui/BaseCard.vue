<script setup lang="ts">
import { computed, resolveDynamicComponent } from "vue";

const props = withDefaults(
  defineProps<{
    as?: string | object; // 'article' | 'div' | NuxtLink etc.
    href?: string; // dacă treci href, devine link
    rounded?: "lg" | "xl" | "2xl";
    tone?: "white" | "subtle"; // fundal
    shadow?: "none" | "sm" | "md";
    padded?: boolean;
    hover?: boolean;
    class?: string;
  }>(),
  {
    as: "article",
    rounded: "2xl",
    tone: "white",
    shadow: "sm",
    padded: true,
    hover: true,
  }
);

const rootTag = computed(() => {
  if (props.href) return "NuxtLink";
  return props.as;
});

const toneClass = computed(
  () =>
    ({
      white: "bg-white/90",
      subtle: "bg-slate-50/80",
    }[props.tone])
);

const roundedClass = computed(
  () =>
    ({
      lg: "rounded-lg",
      xl: "rounded-xl",
      "2xl": "rounded-2xl",
    }[props.rounded])
);

const shadowClass = computed(
  () =>
    ({
      none: "",
      sm: "shadow-sm",
      md: "shadow",
    }[props.shadow])
);

const padClass = computed(() => (props.padded ? "p-5" : ""));
const hoverClass = computed(() =>
  props.hover ? "hover:shadow md:transition-shadow" : ""
);
</script>

<template>
  <component
    :is="resolveDynamicComponent(rootTag)"
    :to="href"
    :href="href"
    class="relative border border-slate-200/70 backdrop-blur"
    :class="[
      toneClass,
      roundedClass,
      shadowClass,
      padClass,
      hoverClass,
      props.class,
    ]"
  >
    <!-- zone opționale -->
    <div v-if="$slots.header" class="mb-3">
      <slot name="header" />
    </div>

    <div v-if="$slots.default">
      <slot />
    </div>

    <div v-if="$slots.footer" class="mt-4">
      <slot name="footer" />
    </div>

    <!-- colț dreapta-sus: badge/status/icoane -->
    <div v-if="$slots.badge" class="absolute right-4 top-3">
      <slot name="badge" />
    </div>
  </component>
</template>
