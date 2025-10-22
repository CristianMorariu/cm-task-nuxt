<script setup>
const { $api } = useNuxtApp();

const newUser = reactive({
  fullName: "Test Project",
  username: "",
  email: "",
  avatar: null,
  role: null,
  password: "",
});
const rolesOptions = ref([]);
onMounted(async () => {
  const response = await $api("/api/meta/roles");
  rolesOptions.value = response.data.reverse();

  console.log(rolesOptions.value);
});
watch(
  () => newUser.avatar,
  (val) => {
    console.log(val);
  }
);
function submit() {
  console.log(newUser.value);
}
</script>
<template>
  <div class="space-y-6 lg:max-w-[80%] xl:max-w-[70%] 2xl:max-w-[60%]">
    <h1 class="text-3xl font-semibold text-slate-700">Add new user</h1>

    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
      <!-- grid 2 coloane -->
      <div class="grid gap-5 sm:grid-cols-2 flex-wrap">
        <div class="flex flex-col gap-3">
          <UiInput
            v-model="newUser.fullName"
            label="Enter full name"
            placeholder="Full name"
          />
          <UiInput
            v-model="newUser.email"
            label="Enter email"
            placeholder="Email"
          />
          <UiInput
            class="sm:mt-3"
            v-model="newUser.password"
            type="password"
            label="Enter password"
            placeholder="Password"
          />
        </div>
        <!-- <div class="mt-6">
        <p class="mb-2 text-slate-600 font-medium">Add documents and files</p>
        <UiFileList v-model="form.files" />
        </div> -->

        <div class="flex flex-col">
          <UiAvatarInput v-model="newUser.avatar" class="sm:mt-5" />
          <div class="relative mt-4">
            <label for="select"
              ><span class="block mb-1 text-sm font-medium text-slate-600"
                >Choose user role</span
              >

              <select
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
          </div>
        </div>
      </div>
      <!-- <UiSelectUser
        v-model="newUser.role"
        :options="rolesOptions"
        label="Assign supervisor"
        placeholder="Search"
      /> -->

      <!-- <p class="mt-4 text-sm text-red-500 italic">
          *All fields are mandatory
        </p> -->
      <div class="my-5 flex flex-col gap-3 sm:flex-row sm:justify-end">
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

<style scoped></style>
