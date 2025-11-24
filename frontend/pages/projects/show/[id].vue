<script setup lang="ts">
// props / mock; în proiectul tău le alimentezi din API
// const project = {
//   title: "Restaurant App",
//   deadlineFormatted: "22.04.2022",
//   description: [
//     "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.",
//     "It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.",
//   ],
//   supervisor: {
//     fullName: "Cody Fisher",
//     email: "cody@example.com",
//     avatarUrl: "https://i.pravatar.cc/100?img=7",
//   },
// };

const documents = [
  { id: 1, name: "Document 1.pdf", size: "245 KB" },
  { id: 2, name: "Document 2.docx", size: "1.2 MB" },
  { id: 3, name: "Document 3.pdf", size: "842 KB" },
  { id: 4, name: "Document 4.docx", size: "513 KB" },
  { id: 5, name: "Document 5.pdf", size: "312 KB" },
];

const tasks = [
  {
    id: 1,
    title: "Design Menu",
    status: "todo",
    deadlineFormatted: "22.04.2022",
    excerpt: lorem(),
    isOverdue: false,
  },
  {
    id: 2,
    title: "Design Navbar",
    status: "taken",
    deadlineFormatted: "22.04.2022",
    excerpt: lorem(),
    isOverdue: false,
  },
  {
    id: 3,
    title: "Design Menu",
    status: "in_progress",
    deadlineFormatted: "24.04.2022",
    excerpt: lorem(),
    isOverdue: true,
  },
  {
    id: 4,
    title: "Design Menu",
    status: "done",
    deadlineFormatted: "22.04.2022",
    excerpt: lorem(),
    isOverdue: false,
  },
  {
    id: 5,
    title: "Design Menu",
    status: "todo",
    deadlineFormatted: "22.04.2022",
    excerpt: lorem(),
    isOverdue: false,
  },
  {
    id: 6,
    title: "Design Menu",
    status: "in_progress",
    deadlineFormatted: "22.04.2022",
    excerpt: lorem(),
    isOverdue: false,
  },
];

const selectedFilter = ref("all");

function statusLabel(s: string) {
  return (
    {
      todo: "TO DO",
      in_progress: "IN PROGRESS",
      taken: "TAKEN",
      done: "DONE",
    }[s] ?? s
  );
}

function statusClass(s: string) {
  return (
    {
      todo: "bg-orange-100 text-orange-700",
      in_progress: "bg-sky-100 text-sky-700",
      taken: "bg-cyan-100 text-cyan-700",
      done: "bg-emerald-100 text-emerald-700",
    }[s] ?? "bg-slate-100 text-slate-700"
  );
}

function lorem() {
  return "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's.";
}
const { $api } = useNuxtApp();
const route = useRoute();

const project = ref({});
onMounted(async () => {
  try {
    const resp = await $api.get(`/api/projects/${route.params.id}`);
    project.value = resp.data;
    console.log(project.value);
  } catch (error) {
    console.log(error);
  }
});
</script>

<template>
  <div class="mx-auto max-w-7xl">
    <!-- Title -->
    <h1 class="text-2xl font-semibold text-slate-900">{{ project.title }}</h1>

    <!-- Top: Description + Docs -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <!-- Description card -->
      <UiBaseCard class="lg:col-span-2">
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
          <p v-for="(para, i) in project.description" :key="i">{{ para }}</p>
        </div>

        <!-- Supervisor -->
        <div class="mt-6">
          <div class="text-slate-900 font-medium">Supervisor</div>
          <div class="mt-3 flex items-center gap-3">
            <img
              :src="project.supervisor.avatarUrl"
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
      <aside class="lg:col-span-1">
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
                <!-- icons placeholder -->
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
      </aside>
    </div>

    <!-- Tasks header -->
    <div class="flex items-center justify-between">
      <h2 class="text-xl font-semibold text-slate-900">Tasks</h2>
      <div class="flex items-center gap-3">
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
      </div>
    </div>

    <!-- Tasks grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
      <article
        v-for="task in tasks"
        :key="task.id"
        class="rounded-2xl bg-white shadow-sm ring-1 ring-black/5 p-5 flex flex-col"
      >
        <div class="flex items-start justify-between">
          <h3 class="text-lg font-semibold text-slate-900">{{ task.title }}</h3>
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
          <span class="ml-1">{{ task.deadlineFormatted }}</span>
          <span v-if="task.isOverdue" class="ml-2 text-red-600 font-semibold"
            >Overdue</span
          >
        </div>

        <p class="mt-3 line-clamp-3 text-slate-600">
          {{ task.excerpt }}
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
</template>
