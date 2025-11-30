<script setup>
const toast = useToast();
const addTaskModal = ref(false);
const newTask = reactive({
  name: "",
  status: "todo",
  dueDate: "",
  description: "",
  priority: "medium",
  completedAt: "",
  assignee: [],
});

const statusList = ["todo", "doing", "done"];
const priorityList = ["low", "medium", "high"];

// const tasks = [
//   {
//     id: 1,
//     title: "Design Menu",
//     status: "todo",
//     deadlineFormatted: "22.04.2022",
//     excerpt: lorem(),
//     isOverdue: false,
//   },
//   {
//     id: 2,
//     title: "Design Navbar",
//     status: "taken",
//     deadlineFormatted: "22.04.2022",
//     excerpt: lorem(),
//     isOverdue: false,
//   },
// ];

const selectedFilter = ref("all");

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

const { $api } = useNuxtApp();
const route = useRoute();

const project = ref({});
const tasks = ref({});
const users = ref(null);
onMounted(async () => {
  try {
    const resp = await $api.get(`/api/projects/${route.params.id}`);
    project.value = resp.data;
    console.log(project.value);
    await refreshTasks();
    // const resp1 = await $api.get(`/api/projects/${project.value.id}/tasks`);
    // tasks.value = resp1.data;
    const usr = await $api.get("/api/users");
    users.value = usr.data;
    console.log(users.value);
    console.log(tasks.value);
  } catch (error) {
    console.log(error);
  }
});
const refreshTasks = async () => {
  const resp1 = await $api.get(`/api/projects/${project.value.id}/tasks`);
  tasks.value = resp1.data;
};
const createTask = () => {
  console.log(newTask);
  $api
    .post(`/api/projects/${project.value.id}/tasks`, newTask)
    .then(async (response) => {
      await refreshTasks();
      addTaskModal.value = false;
      toast.success({
        title: "Task nou creat!",
        message: "Taskul a fost creat cu success.",
      });
    })
    .catch((error) => console.log(error));
};
</script>

<template>
  <div class="mx-auto max-w-7xl">
    <!-- Title -->
    <h1 class="text-2xl font-semibold text-slate-900 mb-3">
      {{ project.name }}
    </h1>

    <!-- Top: Description + Docs -->
    <!-- class="grid grid-cols-1 lg:grid-cols-3 gap-6" -->
    <div>
      <!-- Description card -->
      <!-- class="lg:col-span-2" -->
      <UiBaseCard class="w-full min-h-52">
        <div class="flex items-start justify-between gap-4">
          <h2 class="text-lg font-semibold text-slate-900">
            Project Description
          </h2>
          <span
            class="text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-full px-3 py-1"
          >
            Deadline: {{ project.deadlineFormatted }}
          </span>
        </div>

        <div class="mt-4 space-y-4 text-slate-600 leading-relaxed">
          <p>{{ project.description }}</p>
        </div>

        <!-- Supervisor -->
        <div class="mt-6">
          <div class="text-slate-900 font-medium">Supervisor</div>
          <div class="mt-3 flex items-center gap-3" v-if="project.supervisor">
            <img
              :src="project.supervisor?.avatarUrl"
              alt=""
              class="h-10 w-10 rounded-full object-cover ring-1 ring-black/10"
            />
            <div class="leading-tight">
              <div class="font-semibold text-slate-900">
                {{ project.supervisor.fullName }}
              </div>
              <div class="text-xs text-slate-500">
                {{ project.supervisor.email }}
              </div>
            </div>
          </div>
        </div>
      </UiBaseCard>

      <!-- Documentation card -->
      <!-- <aside class="lg:col-span-1">
        <div
          class="rounded-2xl bg-white shadow-sm ring-1 ring-black/5 p-6 lg:sticky lg:top-6"
        >
          <h2 class="text-lg font-semibold text-slate-900">Documentation</h2>

          <ul class="mt-4 space-y-3 max-h-72 overflow-auto pr-1">
            <li
              v-for="doc in documents"
              :key="doc.id"
              class="flex items-center justify-between gap-3 rounded-xl border border-slate-200 px-3 py-2 hover:bg-slate-50"
            >
              <div class="min-w-0">
                <p class="truncate text-sm font-medium text-slate-900">
                  {{ doc.name }}
                </p>
                <p class="truncate text-xs text-slate-500">{{ doc.size }}</p>
              </div>
              <div class="flex items-center gap-2 shrink-0 text-slate-400">
                <button title="Download" class="hover:text-slate-600">
                  ⬇️
                </button>
                <button title="Preview" class="hover:text-slate-600">👁️</button>
                <button title="Remove" class="hover:text-red-600">🗑️</button>
              </div>
            </li>
          </ul>

          <button
            type="button"
            class="mt-5 w-full rounded-full bg-cyan-500 text-white font-semibold py-2.5 hover:bg-cyan-600"
          >
            UPLOAD FILE
          </button>
        </div>
      </aside> -->
    </div>

    <!-- Tasks header -->
    <div class="flex items-center justify-between my-5">
      <h2 class="text-xl font-semibold text-slate-900">Tasks</h2>
      <button
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300"
        @click="addTaskModal = true"
      >
        <span class="text-sm">Adaugă task</span>
      </button>
      <!-- <div class="flex items-center gap-3">
        <label class="sr-only">Filter</label>
        <div class="relative">
          <select
            class="appearance-none rounded-full bg-white shadow-sm ring-1 ring-black/5 text-sm py-2 pl-4 pr-9"
            v-model="selectedFilter"
          >
            <option value="all">All</option>
            <option value="todo">To do</option>
            <option value="in_progress">In progress</option>
            <option value="taken">Taken</option>
            <option value="done">Done</option>
          </select>
          <span
            class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400"
            >▾</span
          >
        </div>
      </div> -->
    </div>

    <!-- Tasks grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
      <article
        v-for="task in tasks"
        :key="task.id"
        class="rounded-2xl bg-white shadow-sm ring-1 ring-black/5 p-5 flex flex-col"
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
          <span class="ml-2 text-red-600 font-semibold">{{
            task.priority
          }}</span>
        </div>

        <p class="mt-3 line-clamp-3 text-slate-600">
          {{ task.description }}
        </p>

        <div class="mt-4 flex items-center gap-3 text-slate-400">
          <!-- small action icons placeholders -->
          <button title="Edit" class="hover:text-slate-600">✏️</button>
          <button title="Comment" class="hover:text-slate-600">💬</button>
          <button title="Link" class="hover:text-slate-600">🔗</button>
        </div>

        <button
          type="button"
          class="mt-5 rounded-full bg-amber-500 text-white font-semibold py-2 hover:bg-amber-600"
        >
          TAKE TASK
        </button>
      </article>
    </div>
  </div>

  <UiModal v-model="addTaskModal" title="Add New Task" size="lg">
    <form class="space-y-4" @submit.prevent="">
      <!-- grid 2 coloane -->
      <div class="grid gap-6 sm:grid-cols-2">
        <UiInput
          v-model="newTask.name"
          label="Task name"
          placeholder="Task name"
        />

        <UiDateInput v-model="newTask.dueDate" label="Deadline" />
        <div class="relative mt-4">
          <label for="select"
            ><span class="block mb-1 text-sm font-medium text-slate-600"
              >Choose task status
            </span>

            <select
              v-model="newTask.status"
              class="w-full h-[45px] bg-transparent border border-slate-200 rounded-full pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-sky-300 focus:ring-2 focus:ring-sky-200 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer"
            >
              <option
                v-for="status in statusList"
                :value="status"
                class="rounded-full"
              >
                {{ status.toUpperCase() }}
              </option>
            </select>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.2"
              stroke="currentColor"
              class="h-5 w-5 absolute top-9 right-2.5 text-slate-700"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"
              />
            </svg>
          </label>
        </div>
        <div class="relative mt-4">
          <label for="select"
            ><span class="block mb-1 text-sm font-medium text-slate-600"
              >Choose task priority</span
            >

            <select
              v-model="newTask.priority"
              class="w-full h-[45px] bg-transparent border border-slate-200 rounded-full pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-sky-300 focus:ring-2 focus:ring-sky-200 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer"
            >
              <option
                v-for="priority in priorityList"
                :value="priority"
                class="rounded-full"
              >
                {{ priority.toUpperCase() }}
              </option>
            </select>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.2"
              stroke="currentColor"
              class="h-5 w-5 absolute top-9 right-2.5 text-slate-700"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"
              />
            </svg>
          </label>
        </div>
      </div>

      <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <UiSelectUser
          v-if="users"
          v-model="newTask.assignee.id"
          :options="users"
          label="Assign supervisor"
          placeholder="Search"
        />

        <!-- preview-ul e deja în componentă prin chip; las celula dreaptă goală pentru aliniere -->
        <div />
      </div>

      <div class="mt-6">
        <UiTextarea
          v-model="newTask.description"
          label="Project description"
          placeholder="Write the description"
          :rows="6"
        />
      </div>
    </form>

    <template #footer>
      <UiButton intent="secondary" @click="addTaskModal = false"
        >Cancel</UiButton
      >
      <UiButton @click="createTask">Add Task</UiButton>
    </template>
  </UiModal>
</template>
