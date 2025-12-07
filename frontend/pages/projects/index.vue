<script setup>
import { Edit, Trash } from "lucide-vue-next";
import UserPlaceholder from "@/assets/userPlaceholder.jpg";

const { $api } = useNuxtApp();
const dataTable = ref(null);
const router = useRouter();
const toast = useToast();
const projectToDelete = ref();
const openDelete = ref(false);

onMounted(() => {
  refreshProjects();
});

const refreshProjects = async () => {
  try {
    const resp = await $api.get("/api/projects");
    dataTable.value = resp.data;
  } catch (_) {}
};

async function deleteProject() {
  // console.log(projectToDelete.value);
  try {
    const resp = await $api.delete(`/api/projects/${projectToDelete.value}`);
    await refreshProjects();
    openDelete.value = false;
    toast.success({
      title: "Proiect șters!",
      message: "Proiect șters cu success.",
    });
  } catch (error) {
    console.log(error);
    toast.error({
      title: "Eroare",
      message: "A aparut o eroare la stergere.",
    });
  }
}
</script>
<template>
  <div class="w-full flex justify-between mb-4">
    <h2 class="text-5xl font-semibold text-slate-700">Projects</h2>

    <UiButton
      @click="router.push({ name: 'projects-create-project' })"
      class="bg-[#00C7C7] hover:bg-[#00B7B7]"
      >ADD PROJECT</UiButton
    >
  </div>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
    <UiBaseCard v-for="project in dataTable" :key="project.id">
      <template #header>
        <div class="flex items-start justify-between gap-3">
          <h3 class="text-xl font-semibold">{{ project.name }}</h3>
          <div class="flex items-center gap-2 text-slate-400">
            <div />
            <div class="text-green-600 font-semibold">
              Deadline: {{ project.deadlineFormatted }}
            </div>

            <button
              @click="
                router.push({
                  name: 'projects-edit-project-id',
                  params: { id: project.id },
                })
              "
            >
              <Edit color="blue" class="h-5 w-5" />
            </button>
            <button
              @click="
                () => {
                  projectToDelete = project.id;
                  openDelete = true;
                }
              "
            >
              <Trash color="red" class="h-5 w-5" />
            </button>
          </div>
        </div>
      </template>

      <p class="text-slate-500">
        {{ project.description }}
      </p>

      <template #footer>
        <footer class="mt-4 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <img
              :src="project.supervisor.avatarUrl ?? UserPlaceholder"
              alt=""
              class="h-8 w-8 rounded-full object-cover ring-1 ring-black/10"
            />

            <span class="text-slate-700 font-medium">{{
              project?.supervisor?.username
            }}</span>
          </div>

          <div class="mt-3 flex justify-end">
            <UiButton
              @click="
                router.push({
                  name: 'projects-show-id',
                  params: { id: project.id },
                })
              "
              class="px-4"
              >DETAILS</UiButton
            >
          </div>
        </footer>
      </template>
    </UiBaseCard>
  </div>

  <UiModal v-model="openDelete" title="Delete Project" size="lg">
    <form class="space-y-4">
      <p>Are you sure you want to delete this project ?</p>
    </form>

    <template #footer>
      <UiButton intent="secondary" @click="openDelete = false">Cancel</UiButton>
      <UiButton @click="deleteProject">Delete</UiButton>
    </template>
  </UiModal>
</template>

<style scoped></style>
