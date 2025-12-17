<script setup lang="ts">
import { ref, onMounted } from "vue";

const route = useRoute();
const { $api } = useNuxtApp();
const toast = useToast();
const task = ref<any>(null);
const loading = ref(true);
const saving = ref(false);

// load task
async function fetchTask() {
  loading.value = true;
  try {
    const res = await $api.get(`/api/tasks/${route.params.id}`);
    task.value = res.data;
    // console.log(task.value);
  } finally {
    loading.value = false;
  }
}

onMounted(fetchTask);

// update status
async function updateStatus(newStatus: string) {
  saving.value = true;
  try {
    const res = await $api.patch(`/api/tasks/${route.params.id}/status`, {
      status: newStatus,
    });
    fetchTask();
    toast.success({
      title: "Status actualizat",
      message: "Statusul a fost actualizat cu success.",
    });
  } finally {
    saving.value = false;
  }
}
</script>

<template>
  <UiBaseCard class="w-full min-h-52">
    <div class="flex items-start justify-between gap-4">
      <h2 class="text-lg font-semibold text-slate-900">Project Description</h2>
      <span
        class="text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-full px-3 py-1"
      >
        Deadline: {{ task?.project.deadlineFormatted }}
      </span>
    </div>

    <div class="mt-4 space-y-4 text-slate-600 leading-relaxed">
      <p>{{ task?.project.description }}</p>
    </div>
  </UiBaseCard>
  <div class="p-6">
    <!-- Loading -->
    <div v-if="loading" class="text-gray-500">Loading task...</div>

    <div v-else>
      <h1 class="text-2xl font-bold mb-4">
        {{ task.name }}
      </h1>

      <p class="text-gray-700 mb-6">
        {{ task.description }}
      </p>

      <!-- Status -->
      <div class="mb-4">
        <label class="block text-sm text-gray-500 mb-1">Status</label>

        <select
          :disabled="saving"
          v-model="task.status"
          @change="updateStatus(task.status)"
          class="border rounded px-3 py-2"
        >
          <option value="todo">To do</option>
          <option value="doing">Doing</option>
          <option value="done">Done</option>
        </select>
      </div>

      <div v-if="saving" class="text-sm text-gray-500">Saving...</div>
    </div>
  </div>
</template>
