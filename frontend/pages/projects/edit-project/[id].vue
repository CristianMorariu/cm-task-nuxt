<script setup lang="ts">
// mock users (în real: fetch din API)
const users = [
  { id: 1, name: "Devon Lane", avatar: "https://i.pravatar.cc/100?img=5" },
  { id: 2, name: "Cody Fisher", avatar: "https://i.pravatar.cc/100?img=8" },
  { id: 3, name: "Wade Warren", avatar: "https://i.pravatar.cc/100?img=12" },
];
const route = useRoute();

const { $api } = useNuxtApp();
const usersList = ref([]);
const project = ref({
  name: "",
  deadline: "",
  supervisor_id: null as number | null,
  description: "",
  files: [] as File[],
});
onMounted(async () => {
  try {
    const resp = await $api.get(`/api/projects/${route.params.id}`);
    project.value = resp.data;
    const users = await $api.get("/api/users");
    usersList.value = users.data;
    console.log(project.value);
    console.log(usersList.value);
  } catch (error) {
    console.log(error);
  }
});
async function submit() {
  // construiește payload; pentru fișiere, folosește FormData
  // const fd = new FormData();
  // fd.append("name", form.name);
  // if (form.deadline) fd.append("deadline", form.deadline);
  // if (form.supervisor_id)
  //   fd.append("supervisor_id", String(form.supervisor_id));
  // if (form.description) fd.append("description", form.description);
  // form.files.forEach((f, i) => fd.append(`files[${i}]`, f));

  // console.log("submit ->", Object.fromEntries(fd as any));
  console.log(project.value);
}
</script>

<template>
  <div class="space-y-6">
    <h1 class="text-3xl font-semibold text-slate-700">Edit project</h1>

    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
      <!-- grid 2 coloane -->
      <div class="grid gap-6 sm:grid-cols-2">
        <UiInput
          v-model="project.name"
          label="Project name"
          placeholder="Full name"
        />

        <UiDateInput v-model="project.deadline" label="Deadline" />
      </div>

      <div class="mt-6 grid gap-6 sm:grid-cols-2">
        <UiSelectUser
          v-model="project.supervisor_id"
          :options="usersList"
          label="Assign supervisor"
          placeholder="Search"
        />

        <!-- preview-ul e deja în componentă prin chip; las celula dreaptă goală pentru aliniere -->
        <div />
      </div>

      <div class="mt-6">
        <UiTextarea
          v-model="project.description"
          label="Project description"
          placeholder="Write the description"
          :rows="6"
        />
      </div>

      <!-- <div class="mt-6">
        <p class="mb-2 text-slate-600 font-medium">Add documents and files</p>
        <UiFileList v-model="form.files" />
      </div> -->

      <p class="mt-4 text-sm text-red-500 italic">*All fields are mandatory</p>

      <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-end">
        <button
          type="button"
          @click="reset"
          class="rounded-full border-2 border-amber-400 px-6 py-2 font-semibold text-amber-500 hover:bg-amber-50"
        >
          RESET
        </button>

        <button
          type="button"
          @click="submit"
          class="rounded-full bg-amber-400 px-6 py-2 font-semibold text-white hover:bg-amber-500"
        >
          ADD PROJECT
        </button>
      </div>
    </div>
  </div>
</template>
