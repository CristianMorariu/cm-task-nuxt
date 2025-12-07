<script setup lang="ts">
const route = useRoute();
const { $api } = useNuxtApp();
const usersList = ref([]);
const router = useRouter();
const toast = useToast();
const project = ref();
onMounted(async () => {
  try {
    const resp = await $api.get(`/api/projects/${route.params.id}`);
    project.value = resp.data;
    const users = await $api.get("/api/users");
    usersList.value = users.data;
  } catch (error) {
    console.log(error);
  }
});
async function submit() {
  try {
    const resp = await $api.put(`/api/projects/${project.value.id}`, {
      name: project.value.name,
      description: project.value.description,
      deadline: project.value.deadline,
      status: project.value.status,
      supervisor_id: project.value.supervisor_id,
    });
    router.push({ name: "projects" });
    toast.success({
      title: "Proiect actualizat!",
      message: "Proiectul a fost actualizat cu success.",
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
    <h1 class="text-3xl font-semibold text-slate-700">Edit project</h1>

    <div
      v-if="project"
      class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70"
    >
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
          @click="submit"
          class="rounded-full bg-amber-400 px-6 py-2 font-semibold text-white hover:bg-amber-500"
        >
          EDIT PROJECT
        </button>
      </div>
    </div>
  </div>
</template>
