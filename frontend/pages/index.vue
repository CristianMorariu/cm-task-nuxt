<script setup>
const { $api } = useNuxtApp();
const myTasks = ref();
const router = useRouter();

onMounted(async () => {
  try {
    const resp = await $api.get("/api/my-tasks");
    myTasks.value = resp.data;
    console.log(myTasks.value);
  } catch (error) {
    console.log(error);
  }
});

function statusLabel(s) {
  return (
    {
      todo: "TO DO",
      doing: "IN PROGRESS",
      taken: "TAKEN",
      done: "DONE",
    }[s] ?? s
  );
}

function statusClass(s) {
  return (
    {
      todo: "bg-orange-100 text-orange-700",
      in_progress: "bg-sky-100 text-sky-700",
      taken: "bg-cyan-100 text-cyan-700",
      done: "bg-emerald-100 text-emerald-700",
    }[s] ?? "bg-slate-100 text-slate-700"
  );
}
</script>

<template>
  <h1 class="text-2xl font-semibold text-slate-900 mb-5">My tasks</h1>
  <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
    <article
      v-for="task in myTasks"
      :key="task.id"
      class="rounded-2xl bg-white shadow-sm ring-1 ring-black/5 p-5 flex flex-col justify-between"
    >
      <div class="flex items-start justify-between">
        <h3 class="text-lg font-semibold text-slate-900">{{ task.name }}</h3>
        <span
          :class="[
            'text-xs font-bold rounded-full px-2.5 py-1',
            statusClass(task.status),
          ]"
        >
          {{ statusLabel(task.status) }}
        </span>
      </div>

      <div class="mt-2 text-xs text-emerald-700">
        <span class="font-semibold">Deadline.</span>
        <span class="ml-1">{{ task.dueDate }}</span>
        <!-- <span v-if="task.isOverdue" class="ml-2 text-red-600 font-semibold"
            >Overdue</span
          > -->
        <span class="ml-2 text-red-600 font-semibold">{{ task.priority }}</span>
      </div>

      <p class="mt-3 line-clamp-3 text-slate-600">
        {{ task.description }}
      </p>

      <button
        @click="
          router.push({
            name: 'task-id',
            params: { id: task.id },
          })
        "
        type="button"
        class="mt-5 rounded-full bg-amber-500 text-white font-semibold py-2 hover:bg-amber-600"
      >
        VIEW
      </button>
    </article>
  </div>
</template>

<style scoped></style>
