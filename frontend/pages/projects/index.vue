<script setup>
import UserPlaceholder from "@/assets/userPlaceholder.jpg";
const { $api } = useNuxtApp();
const dataTable = ref(null);
const openEdit = ref(false);
const openDelete = ref(false);
const router = useRouter();
onMounted(async () => {
  try {
    const resp = await $api.get("/api/projects");
    console.log(resp);
    dataTable.value = resp.data;
    console.log(dataTable.value);
  } catch (_) {}
});
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
      <!-- <pre>{{ project }}</pre> -->
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
              title="Edit"
              class="hover:text-slate-600"
            >
              <img
                src="@/assets/edit-2.svg"
                class="h-4 w-4 cursor-pointer hover:text-slate-600"
              />
            </button>
            <button title="Link" class="hover:text-slate-600">
              <img
                src="@/assets/slash.svg"
                class="h-4 w-4 cursor-pointer hover:text-slate-600"
              />
            </button>
          </div>
        </div>
      </template>

      <p class="text-slate-500">
        <!-- Lorem Ipsum is simply dummy text of the printing and types industry.
        Lorem Ipsum has been the industry's… -->
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
</template>

<style scoped></style>
