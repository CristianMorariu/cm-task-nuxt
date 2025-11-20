<script setup>
const { $api } = useNuxtApp();
const users = ref(null);
const router = useRouter();
const toast = useToast();
const openDelete = ref(false);
const userToDelete = ref({});
const roleLabel = (r) =>
  ({ admin: "Administrator", manager: "Manager", user: "Employee" }[r] ?? r);

const roleClass = (r) =>
  ({
    admin: "bg-orange-100 text-orange-800 ring-1 ring-orange-200",
    manager: "bg-blue-100 text-blue-800 ring-1 ring-blue-200",
    user: "bg-gray-100 text-gray-800 ring-1 ring-gray-200",
  }[r] ?? "bg-gray-100 text-gray-800 ring-1 ring-gray-200");

onMounted(() => {
  fetchUsers();
});

async function fetchUsers() {
  try {
    const resp = await $api.get("/api/users");
    console.log(resp);
    users.value = resp.data;
  } catch (error) {
    console.log(error);
  }
}
async function deleteUser() {
  try {
    const resp = await $api.delete(`/api/users/${userToDelete.value}`);
    fetchUsers();
    openDelete.value = false;
    toast.success({
      title: "User șters!",
      message: "User șters cu success.",
    });
  } catch (error) {
    console.log(error);
    toast.error({
      title: "Eroare",
      message: "User șters cu success.",
    });
  }
}
</script>
<template>
  <div>
    <div class="flex justify-between mb-4">
      <h2 class="text-5xl font-semibold text-slate-700">Users</h2>

      <UiButton
        @click="router.push({ name: 'users-create-user' })"
        class="!bg-[#00C7C7] !hover:bg-[#00B7B7] px-5"
        >ADD USER</UiButton
      >
    </div>

    <Table v-if="users" :data="users">
      <template #thead>
        <th class="px-4 py-2">ID</th>
        <th class="px-4 py-2">Full Name</th>
        <th class="px-4 py-2">Username</th>
        <th class="px-4 py-2">Email</th>
        <th class="px-4 py-2">Role</th>
        <th class="px-4 py-2">Avatar</th>
        <th class="px-4 py-2"></th>
      </template>
      <template #row="{ row }">
        <td class="px-4 py-2">{{ row.id }}</td>
        <td class="px-4 py-2">{{ row.fullName }}</td>
        <td class="px-4 py-2">{{ row.username }}</td>
        <td class="px-4 py-2">{{ row.email }}</td>
        <td class="px-4 py-2">
          <span
            :class="[
              'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium',
              roleClass(row.role),
            ]"
          >
            {{ roleLabel(row.role) }}
          </span>
        </td>
        <td class="px-4 py-2">
          <div class="flex items-center justify-center gap-3">
            <img
              :src="row.avatarUrl"
              alt=""
              class="h-8 w-8 rounded-full object-cover ring-1 ring-black/10"
            />
          </div>
        </td>
        <td class="px-4 py-2">
          <div class="flex items-center gap-2 text-gray-400">
            <button title="Edit" class="hover:text-gray-600">
              <IconsEdit
                @click="
                  router.push({
                    name: 'users-edit-user-id',
                    params: { id: row.id },
                  })
                "
                class="h-4 w-4"
              />
            </button>

            <button
              @click="
                () => {
                  userToDelete = row.id;
                  openDelete = true;
                }
              "
              title="Delete"
            >
              <IconsDelete class="h-4 w-4" />
            </button>
          </div>
        </td>
      </template>
    </Table>
  </div>
  <UiModal v-model="openDelete" title="Delete User" size="lg">
    <form class="space-y-4">
      <p>Are you sure you want to delete this user ?</p>
    </form>

    <template #footer>
      <UiButton intent="secondary" @click="openDelete = false">Cancel</UiButton>
      <UiButton @click="deleteUser">Delete</UiButton>
    </template>
  </UiModal>
</template>

<style scoped></style>
