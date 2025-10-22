<script setup>
import UserPlaceholder from "@/assets/userPlaceholder.jpg";
const file = ref();
const src = ref();
const avatar = defineModel();
function browse() {
  //   console.log(file);
  file.value.click();
}
function change(e) {
  //   console.log(e.target.files[0]);
  avatar.value = e.target.files[0];
  //   console.log(avatar.value);
  let reader = new FileReader();
  reader.readAsDataURL(e.target.files[0]);
  reader.onload = (e) => {
    src.value = e.target.result;
  };
}
</script>
<template>
  <UiBaseCard class="!bg-gray-50">
    <input
      ref="file"
      type="file"
      accept="image/*"
      class="hidden"
      @change="change"
    />
    <div class="flex items-center space-x-3 cursor-default">
      <div
        class="overflow-hidden rounded-full ring-2 ring-gray-700 dark:ring-gray-100"
      >
        <img
          :src="src ?? UserPlaceholder"
          alt="User avatar"
          class="h-24 w-24 rounded-full object-cover"
        />
      </div>
      <div class="grid grid-cols-1 gap-2">
        <p>{{ avatar?.name ?? "avatar.png" }}</p>
        <UiButton
          @click="browse"
          class="!bg-[#00C7C7] !hover:bg-[#00B7B7] px-4 h-11"
          >UPLOAD IMAGE</UiButton
        >
      </div>
    </div>
  </UiBaseCard>
</template>

<style scoped></style>
