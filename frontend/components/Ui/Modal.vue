<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref, watch, nextTick } from "vue";

type Size = "sm" | "md" | "lg" | "xl" | "full";

const props = withDefaults(
  defineProps<{
    /** v-model */
    modelValue: boolean;
    /** titlul folosit pentru aria-labelledby dacă nu trimiți slot header */
    title?: string;
    /** sm/md/lg/xl/full */
    size?: Size;
    /** închide cu click pe backdrop */
    closeOnBackdrop?: boolean;
    /** închide cu Esc */
    closeOnEsc?: boolean;
    /** blochează scroll pe body când e deschis */
    lockScroll?: boolean;
    /** id pentru aria-labelledby (dacă vrei unul stabil) */
    labelId?: string;
    /** autofocus pe un selector din interior când se deschide */
    initialFocus?: string;
  }>(),
  {
    size: "md",
    closeOnBackdrop: true,
    closeOnEsc: true,
    lockScroll: true,
  }
);

const emit = defineEmits<{
  (e: "update:modelValue", v: boolean): void;
  (e: "open"): void;
  (e: "close"): void;
}>();

const open = computed({
  get: () => props.modelValue,
  set: (v) => emit("update:modelValue", v),
});

const panelRef = ref<HTMLElement | null>(null);
const previouslyFocused = ref<HTMLElement | null>(null);

const sizeClass = computed(
  () =>
    ({
      sm: "max-w-sm",
      md: "max-w-md",
      lg: "max-w-lg",
      xl: "max-w-2xl",
      full: "max-w-3xl sm:max-w-4xl md:max-w-5xl lg:max-w-6xl",
    }[props.size])
);

/** lock scroll pe <html> ca să nu sară layout-ul */
function lockBody() {
  document.documentElement.classList.add("overflow-hidden");
}
function unlockBody() {
  document.documentElement.classList.remove("overflow-hidden");
}

/** focus trap minimalist */
function onKeydown(e: KeyboardEvent) {
  if (props.closeOnEsc && e.key === "Escape") {
    e.stopPropagation();
    close();
  }
  if (e.key !== "Tab") return;
  const root = panelRef.value;
  if (!root) return;
  const focusables = root.querySelectorAll<HTMLElement>(
    'a[href], button, textarea, input, select, [tabindex]:not([tabindex="-1"])'
  );
  if (!focusables.length) return;
  const first = focusables[0];
  const last = focusables[focusables.length - 1];
  const active = document.activeElement as HTMLElement | null;
  if (e.shiftKey && active === first) {
    e.preventDefault();
    last.focus();
  } else if (!e.shiftKey && active === last) {
    e.preventDefault();
    first.focus();
  }
}

function close() {
  open.value = false;
  emit("close");
}

watch(open, async (v) => {
  if (typeof window === "undefined") return;
  if (v) {
    emit("open");
    previouslyFocused.value = document.activeElement as HTMLElement | null;
    if (props.lockScroll) lockBody();
    await nextTick();
    // focus panel sau targetul declarat
    if (props.initialFocus) {
      const el = panelRef.value?.querySelector<HTMLElement>(props.initialFocus);
      el?.focus();
    } else {
      // caută primul focusabil; dacă nu, focus pe panel
      const first = panelRef.value?.querySelector<HTMLElement>(
        'a[href], button, textarea, input, select, [tabindex]:not([tabindex="-1"])'
      );
      (first ?? panelRef.value)?.focus();
    }
    document.addEventListener("keydown", onKeydown, true);
  } else {
    document.removeEventListener("keydown", onKeydown, true);
    if (props.lockScroll) unlockBody();
    previouslyFocused.value?.focus?.();
  }
});

onMounted(() => {
  if (open.value) {
    if (props.lockScroll) lockBody();
    document.addEventListener("keydown", onKeydown, true);
  }
});
onUnmounted(() => {
  document.removeEventListener("keydown", onKeydown, true);
  if (props.lockScroll) unlockBody();
});

const labelId = computed(
  () => props.labelId ?? "modal-title-" + Math.random().toString(36).slice(2)
);
</script>

<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition-opacity duration-150"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition-opacity duration-150"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="open"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        aria-labelledby="labelId"
        role="dialog"
        aria-modal="true"
      >
        <!-- backdrop -->
        <div
          class="absolute inset-0 bg-black/40 backdrop-blur-[1px]"
          @click="closeOnBackdrop ? close() : null"
        />

        <!-- panel -->
        <Transition
          enter-active-class="transition-transform duration-150"
          enter-from-class="translate-y-2 scale-95 opacity-0"
          enter-to-class="translate-y-0 scale-100 opacity-100"
          leave-active-class="transition-transform duration-150"
          leave-from-class="translate-y-0 scale-100 opacity-100"
          leave-to-class="translate-y-2 scale-95 opacity-0"
        >
          <div
            ref="panelRef"
            class="relative w-full focus:outline-none"
            :class="sizeClass"
            tabindex="0"
          >
            <div class="rounded-2xl bg-white shadow-lg ring-1 ring-black/5">
              <!-- header -->
              <div
                v-if="$slots.header || title"
                class="flex items-start justify-between gap-3 p-5 border-b border-slate-200/70"
              >
                <h3 :id="labelId" class="text-lg font-semibold text-slate-800">
                  <slot name="header">{{ title }}</slot>
                </h3>
                <button
                  class="p-1 rounded-md text-slate-400 hover:text-slate-600 hover:bg-slate-100"
                  @click="close"
                  aria-label="Close"
                >
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"
                    />
                  </svg>
                </button>
              </div>

              <!-- body -->
              <div class="p-5">
                <slot />
              </div>

              <!-- footer -->
              <div
                v-if="$slots.footer"
                class="p-4 pt-0 flex items-center justify-end gap-2"
              >
                <slot name="footer" />
              </div>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>
