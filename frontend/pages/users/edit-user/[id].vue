<script setup>
const { $api } = useNuxtApp();
const router = useRouter();
const route = useRoute();
const user = ref({});
const errors = ref({});
const rolesOptions = ref([]);

onMounted(async () => {
  const response = await $api.get(`/api/users/${route.params.id}`);
  user.value = response.data;
  const getRoles = await $api.get("/api/meta/roles");
  rolesOptions.value = getRoles.data.reverse();
  // console.log(response.data);
});

async function submit() {
  try {
    const fd = new FormData();
    if (user.value.username) fd.append("username", user.value.username);
    if (user.value.email) fd.append("email", user.value.email);
    if (user.value.fullName) fd.append("fullName", user.value.fullName);
    if (user.value.role) fd.append("role", user.value.role);
    if (user.value.password) fd.append("password", user.value.password);
    if (user.value.avatar_url instanceof File) {
      fd.append("avatar", user.value.avatar_url);
    }
    fd.append("_method", "PATCH");
    await $api.post(`/api/users/${user.value.id}`, fd);
    router.push({ name: "users" });
  } catch (error) {
    console.log(error);
    errors.value = error.response?.data?.errors ?? {
      message: error.response?.data?.message || "Request failed",
    };
  }
}
</script>
<template>
  <div class="space-y-6 lg:max-w-[80%] xl:max-w-[70%] 2xl:max-w-[60%]">
    <h1 class="text-3xl font-semibold text-slate-700">
      Edit user: <span>{{ user.username }}</span>
    </h1>

    <form
      @submit.prevent=""
      class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70"
    >
      <!-- grid 2 coloane -->
      <div class="grid gap-5 sm:grid-cols-2 flex-wrap">
        <div class="flex flex-col gap-3">
          <UiInput
            v-model="user.fullName"
            label="Enter full name"
            placeholder="Full name"
          />
          <div v-if="errors.fullName" style="color: orangered">
            {{ errors?.fullName[0] }}
          </div>

          <UiInput
            v-model="user.email"
            label="Enter email"
            placeholder="Email"
          />
          <div v-if="errors.email" style="color: orangered">
            {{ errors?.email[0] }}
          </div>
          <UiInput
            class="sm:mt-3"
            v-model="user.password"
            type="password"
            label="Enter password"
            placeholder="Password"
          />
          <div v-if="errors.password" style="color: orangered">
            {{ errors?.password[0] }}
          </div>
        </div>
        <div class="flex flex-col">
          <UiAvatarInput
            v-model="user.avatar_url"
            :src="user.avatar_url"
            class="sm:mt-5"
          />
          <div v-if="errors.avatar" style="color: orangered">
            {{ errors?.avatar[0] }}
          </div>
          <div class="relative mt-4">
            <label for="select"
              ><span class="block mb-1 text-sm font-medium text-slate-600"
                >Choose user role</span
              >

              <select
                v-model="user.role"
                class="w-full h-[45px] bg-transparent border border-slate-200 rounded-full pl-3 pr-8 py-2 transition duration-300 ease focus:outline-none focus:border-sky-300 focus:ring-2 focus:ring-sky-200 hover:border-slate-400 shadow-sm focus:shadow-md appearance-none cursor-pointer"
              >
                <option
                  v-for="role in rolesOptions"
                  :value="role.key"
                  class="rounded-full"
                >
                  {{ role.label }}
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
            <div v-if="errors.role" style="color: orangered">
              {{ errors?.role[0] }}
            </div>
          </div>
        </div>
      </div>

      <div class="my-5 flex flex-col gap-3 sm:flex-row sm:justify-end">
        <UiButton type="button" @click="submit"> EDIT USER </UiButton>
      </div>
    </form>
  </div>
</template>

<style scoped></style>
