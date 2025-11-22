<script setup>
const { $api } = useNuxtApp();
const myProfile = ref({});
const errors = ref({});
const resetPassword = ref({
  current_password: null,
  password: null,
});

const toast = useToast();
onMounted(async () => {
  const response = await $api.get(`/api/me`);
  myProfile.value = response.data;
  console.log(myProfile.value);
});

async function submit() {
  try {
    const fd = new FormData();
    if (myProfile.value.fullName)
      fd.append("fullName", myProfile.value.fullName);
    if (myProfile.value.email) fd.append("email", myProfile.value.email);
    // fișierul (dacă e selectat)
    if (myProfile.value.avatar instanceof File) {
      fd.append("avatar", myProfile.value.avatar, myProfile.value.avatar.name);
    }
    fd.append("_method", "PATCH");
    await $api.post(`/api/me`, fd);

    if (resetPassword.value.password || resetPassword.value.current_password) {
      resetPassword.value.password_confirmation = resetPassword.value.password;
      await $api.patch(`/api/me/password`, resetPassword.value);
    }
    // await auth.logout();
    // trebuie sterse cookiurile si trimis la login
    errors.value = {};
    toast.success({
      title: "User actualizat",
      message: "Profilul a fost actualizat cu success.",
    });
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
    <h1 class="text-3xl font-semibold text-slate-700">My Profile</h1>

    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200/70">
      <!-- grid 2 coloane -->
      <div class="grid gap-5 sm:grid-cols-2 flex-wrap">
        <div class="flex flex-col gap-3">
          <UiInput
            v-model="myProfile.fullName"
            label="Enter full name"
            placeholder="Full name"
          />
          <div v-if="errors.fullName" style="color: orangered">
            {{ errors?.fullName[0] }}
          </div>

          <UiInput
            v-model="myProfile.email"
            label="Enter email"
            placeholder="Email"
          />
          <div v-if="errors.email" style="color: orangered">
            {{ errors?.email[0] }}
          </div>
          <UiInput
            class="sm:mt-3"
            v-model="resetPassword.current_password"
            type="password"
            label="Enter current password"
            placeholder="Current Password"
          />
          <div v-if="errors.password" style="color: orangered">
            {{ errors?.password[0] }}
          </div>
          <div v-if="errors?.message" style="color: orangered">
            {{ errors?.message }}
          </div>
        </div>
        <!-- <div class="mt-6">
        <p class="mb-2 text-slate-600 font-medium">Add documents and files</p>
        <UiFileList v-model="form.files" />
        </div> -->

        <div class="flex flex-col">
          <UiAvatarInput
            v-model="myProfile.avatar"
            :src="myProfile.avatar_url"
            class="sm:mt-5"
          />
          <div v-if="errors.avatar" style="color: orangered">
            {{ errors?.avatar[0] }}
          </div>
          <!-- <div class="relative mt-4">
            <label for="select"
              ><span class="block mb-1 text-sm font-medium text-slate-600"
                >Choose myProfile role</span
              >

              <select
                v-model="myProfile.role"
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
          </div> -->

          <UiInput
            class="sm:mt-3"
            v-model="resetPassword.password"
            type="password"
            label="New password"
            placeholder="New Password"
          />
          <!-- <div v-if="errors.password" style="color: orangered">
            {{ errors?.password[0] }}
          </div> -->
        </div>
      </div>

      <div class="my-5 flex flex-col gap-3 sm:flex-row sm:justify-end">
        <UiButton intent="secondary">RESET</UiButton>

        <UiButton type="button" @click="submit"> EDIT MYPROFILE </UiButton>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
