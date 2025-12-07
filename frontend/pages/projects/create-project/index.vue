<script setup lang="ts">
// mock users (în real: fetch din API)
const { $api } = useNuxtApp();
const users = ref();
const toast = useToast();
const router = useRouter();
const form = reactive({
  name: "",
  description: "",
  supervisor_id: null as number | null,
  deadline: "", // 'YYYY-MM-DD'
  status: "active",
  files: [] as File[],
});
onMounted(async () => {
  const usr = await $api.get("/api/users");
  users.value = usr.data;
});
function reset() {
  form.name = "";
  form.description = "";
  form.supervisor_id = null;
  form.deadline = "";
  form.status = "";
  form.files = [];
}

async function submit() {
  try {
    const resp = await $api.post("/api/projects", form);
    router.push({ name: "projects" });
    toast.success({
      title: "Proiect creat!",
      message: "Proiectul a fost creat cu success.",
    });
  } catch (error) {
    console.log(error);
    toast.error({
      title: "A aparut o eroare!",
    });
  }
}
</script>

<template>
  <div class="space-y-6">
    <h1 class="text-3xl font-semibold text-slate-700">Add new project</h1>

    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
      <!-- grid 2 coloane -->
      <div class="grid gap-6 sm:grid-cols-2">
        <UiInput
          v-model="form.name"
          label="Project name"
          placeholder="Full name"
        />

        <UiDateInput v-model="form.deadline" label="Deadline" />
      </div>

      <div v-if="users" class="mt-6 grid gap-6 sm:grid-cols-2">
        <UiSelectUser
          v-model="form.supervisor_id"
          :options="users"
          label="Assign supervisor"
          placeholder="Search"
        />

        <!-- preview-ul e deja în componentă prin chip; las celula dreaptă goală pentru aliniere -->
        <div />
      </div>

      <div class="mt-6">
        <UiTextarea
          v-model="form.description"
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
