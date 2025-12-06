<script setup>
import { Edit, Trash } from "lucide-vue-next";
const toast = useToast();

const { $api } = useNuxtApp();
const route = useRoute();
const statusList = ["todo", "doing", "done"];
const priorityList = ["low", "medium", "high"];
const selectedFilter = ref("all");
const project = ref({});
const tasks = ref({});
const users = ref(null);
const addTaskModal = ref(false);
const taskToDelete = ref();
const taskToEdit = ref();
const openDelete = ref(false);
const openEdit = ref(false);
const newTask = reactive({
  name: "",
  status: "todo",
  dueDate: "",
  description: "",
  priority: "medium",
  completedAt: "",
  assignee: [],
});

onMounted(async () => {
  try {
    const resp = await $api.get(`/api/projects/${route.params.id}`);
    project.value = resp.data;
    await refreshTasks();
    const usr = await $api.get("/api/users");
    users.value = usr.data;
  } catch (error) {
    console.log(error);
    toast.error({
      title: "A apărut o eroare la incarcarea paginii",
    });
  }
});
watch(selectedFilter, (filter) => {
  const params = {};
  if (filter !== "all") {
    params.status = filter;
  }
  refreshTasks(params);
});

const refreshTasks = async (status) => {
  const resp1 = await $api.get(`/api/projects/${project.value.id}/tasks`, {
    params: { status },
  });
  tasks.value = resp1.data;
};

const createTask = () => {
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

const takeTask = async (idTask) => {
  const takeT = await $api.post(`/api/tasks/${idTask}/take`);
  console.log(takeT);
  toast.success({
    title: "Task luat cu success",
    message: "Taskul a fost luat cu success.",
  });
  refreshTasks();
};

async function deleteTask() {
  try {
    const resp = await $api.delete(`/api/tasks/${taskToDelete.value}`);
    refreshTasks();
    openDelete.value = false;
    toast.success({
      title: "Task șters!",
      message: "Task șters cu success.",
    });
  } catch (error) {
    console.log(error);
    toast.error({
      title: "Eroare",
      message: "A aparut o eroare la stergere.",
    });
  }
}
async function editTask() {
  taskToEdit.value.due_date = taskToEdit.value.dueDate;
  taskToEdit.value.user_id = taskToEdit.value.userId;
  try {
    const resp = await $api.patch(
      `/api/tasks/${taskToEdit.value.id}`,
      taskToEdit.value
    );
    refreshTasks();
    openEdit.value = false;
    toast.success({
      title: "Task actualizat!",
      message: "Task actualizat cu success.",
    });
  } catch (error) {
    console.log(error);
    toast.error({
      title: "Eroare",
      message: "A aparut o eroare.",
    });
  }
}
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
  <div class="mx-auto w-full">
    <h1 class="text-2xl font-semibold text-slate-900 mb-3">
      {{ project.name }}
    </h1>

    <div>
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
    </div>

    <div class="flex items-center justify-between my-5">
      <h2 class="text-xl font-semibold text-slate-900">Tasks</h2>
      <div class="flex gap-5">
        <button
          class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300"
          @click="addTaskModal = true"
        >
          <span class="text-sm">Add new task</span>
        </button>
        <div class="flex items-center gap-3">
          <label class="sr-only">Filter</label>
          <div class="relative">
            <select
              class="appearance-none rounded-full bg-white shadow-sm ring-1 ring-black/5 text-sm py-2 pl-4 pr-9"
              v-model="selectedFilter"
            >
              <option value="all">All</option>
              <option value="todo">To do</option>
              <option value="doing">In progress</option>
              <option value="done">Done</option>
            </select>
            <span
              class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-slate-400"
              >▾</span
            >
          </div>
        </div>
      </div>
    </div>

    <!-- Tasks grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
      <article
        v-for="task in tasks"
        :key="task.id"
        class="rounded-2xl min-h-64 bg-white shadow-sm ring-1 ring-black/5 p-5 flex flex-col justify-between"
      >
        <div class="flex items-start justify-between">
          <h3 class="text-lg font-semibold text-slate-900">{{ task.name }}</h3>

          <div class="flex items-center gap-3 text-slate-400">
            <button
              @click="
                () => {
                  taskToEdit = { ...task };
                  openEdit = true;
                }
              "
              class="hover:text-slate-600"
            >
              <Edit color="blue" />
            </button>
            <button
              @click="
                () => {
                  taskToDelete = task.id;
                  openDelete = true;
                }
              "
              class="hover:text-slate-600"
            >
              <Trash color="red" />
            </button>
          </div>
        </div>

        <div class="text-xs flex items-center justify-between">
          <div class="flex flex-col">
            <div class="flex">
              <span class="font-semibold text-emerald-700">Deadline:</span>
              <span class="ml-1">{{ task.dueDate ?? "N/A" }}</span>
            </div>
            <div class="flex">
              <span class="font-semibold">Priority:</span>
              <span class="ml-2 text-red-600 font-semibold">{{
                task.priority
              }}</span>
            </div>
          </div>
          <span
            :class="[
              'text-xs font-bold rounded-full px-2.5 py-1',
              statusClass(task.status),
            ]"
          >
            {{ statusLabel(task.status) }}
          </span>
        </div>

        <p class="mt-3 line-clamp-3 text-slate-600 border rounded-md p-1">
          <span v-if="task.description">
            {{ task.description }}
          </span>
          <span v-else>Description..</span>
        </p>

        <button
          :disabled="task.assignee"
          @click="takeTask(task.id)"
          type="button"
          class="mt-5 rounded-full bg-amber-500 text-white font-semibold py-2 hover:bg-amber-600 disabled:bg-black"
        >
          {{ task.assignee ? "TAKEN" : "TAKE TASK" }}
        </button>
      </article>
    </div>
  </div>

  <UiModal v-model="addTaskModal" title="Add New Task" size="lg">
    <form class="space-y-4" @submit.prevent="">
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

  <UiModal v-model="openDelete" title="Delete Task" size="lg">
    <form class="space-y-4">
      <p>Are you sure you want to delete this task ?</p>
    </form>

    <template #footer>
      <UiButton intent="secondary" @click="openDelete = false">Cancel</UiButton>
      <UiButton @click="deleteTask">Delete</UiButton>
    </template>
  </UiModal>

  <UiModal v-model="openEdit" title="Edit Task" size="lg">
    <form class="space-y-4" @submit.prevent="">
      <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
      <UiInput v-model="taskToEdit.name" type="text" placeholder="Task name" />
      <select
        v-model="taskToEdit.userId"
        class="w-full border rounded px-3 py-2"
      >
        <option :value="null">Unassigned</option>
        <option v-for="u in users" :key="u.id" :value="u.id">
          {{ u.fullName || u.username || u.email }}
        </option>
      </select>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"
          >Description</label
        >
        <textarea
          v-model="taskToEdit.description"
          rows="3"
          class="w-full border rounded px-3 py-2"
          placeholder="Task description"
        ></textarea>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"
          >Status</label
        >
        <select
          v-model="taskToEdit.status"
          class="w-full border rounded px-3 py-2"
        >
          <option value="todo">To do</option>
          <option value="doing">Doing</option>
          <option value="done">Done</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"
          >Priority</label
        >
        <select
          v-model="taskToEdit.priority"
          class="w-full border rounded px-3 py-2"
        >
          <option value="low">Low</option>
          <option value="medium">Medium</option>
          <option value="high">High</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"
          >Due Date</label
        >
        <input
          v-model="taskToEdit.dueDate"
          type="date"
          class="w-full border rounded px-3 py-2"
        />
      </div>
    </form>

    <template #footer>
      <UiButton variant="ghost" @click="openEdit = false">Cancel</UiButton>
      <UiButton @click="editTask">Save</UiButton>
    </template>
  </UiModal>
</template>
