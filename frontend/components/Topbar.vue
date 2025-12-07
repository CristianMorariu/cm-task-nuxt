<script setup>
const { user } = useAuth();
</script>
<template>
  <header
    class="flex items-center justify-end px-4 md:px-8 py-3 bg-white border-b border-gray-200 shadow-sm"
  >
    <!-- <button class="text-gray-600 text-xl" @click="$emit('toggleSidebar')">
      <Menu />
    </button> -->
    <ClientOnly>
      <div v-if="user" class="flex items-center space-x-3 cursor-default">
        <div class="flex items-center">
          <div
            class="relative h-11 w-11 overflow-hidden rounded-full ring-2 ring-gray-700 dark:ring-gray-100"
          >
            <img
              v-if="user.avatar_url"
              class="rounded-full object-cover"
              :src="user?.avatar_url"
              alt="Avatar"
            />
            <div
              v-else
              class="h-11 w-11 bg-cyan-500 rounded-full text-white flex items-center justify-center"
            >
              {{ user?.username[0].toUpperCase() }}
            </div>
          </div>
          <div class="ml-4">
            <h2 class="font-bold text-gray-800 text-md">
              {{ user?.fullName }}
            </h2>
            <p class="text-gray-600">{{ user?.role }}</p>
          </div>
        </div>
      </div>
    </ClientOnly>
  </header>
</template>
