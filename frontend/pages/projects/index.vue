<script setup>
const { $api } = useNuxtApp();
const dataTable = ref(null);
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
  <div>
    <h2>Projects</h2>
  </div>
  <div class="space-y-3">
    <h2 class="text-2xl font-semibold text-slate-700">Projects</h2>

    <!-- <UiProjectCard
      title="Restaurant App"
      deadline="22.04.2022"
      description="Lorem Ipsum is simply dummy text of the printing and types industry. Lorem Ipsum has been the industry's…"
      author-name="Wade Warren"
      author-avatar="/img/people/wade.jpg"
    >
      <template #actions>
        <img
          src="@/assets/edit-2.svg"
          class="h-4 w-4 cursor-pointer hover:text-slate-600"
        />
        <img
          src="@/assets/slash.svg"
          class="h-4 w-4 cursor-pointer hover:text-slate-600"
        />
      </template>

      <template #cta>
        <UiButton>DETAILS</UiButton>
      </template>
    </UiProjectCard> -->
  </div>

  <div v-for="project in dataTable" class="grid gap-3 grid-cols-2">
    <UiBaseCard class="text-slate-700">
      <template #header>
        <div class="flex items-start justify-between gap-3">
          <h3 class="text-xl font-semibold">Design Menu</h3>
          <div class="flex items-center gap-2 text-slate-400">
            <div />
            <div class="text-green-600 font-semibold">Deadline: 22.04.2022</div>
            <button title="Edit" class="hover:text-slate-600">
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
        Lorem Ipsum is simply dummy text of the printing and types industry.
        Lorem Ipsum has been the industry's…
      </p>

      <template #footer>
        <footer class="mt-4 flex items-center justify-between">
          <div class="flex items-center gap-3">
            <img
              src="@/assets/edit-2.svg"
              alt=""
              class="h-8 w-8 rounded-full object-cover"
            />
            <span class="text-slate-700 font-medium">Wade Warren</span>
          </div>

          <div class="mt-3 flex justify-end">
            <UiButton class="px-4">DETAILS</UiButton>
          </div>
        </footer>
      </template>
    </UiBaseCard>
  </div>
</template>

<style scoped></style>
