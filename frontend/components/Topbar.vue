<script setup>
const { user } = useAuth();
// console.log(user.value);
</script>
<template>
  <header
    class="flex items-center justify-between px-4 md:px-8 py-3 bg-white border-b border-gray-200 shadow-sm"
  >
    <button class="text-gray-600 text-xl" @click="$emit('toggleSidebar')">
      ☰
    </button>

    <h2 class="text-lg font-semibold">Dashboard</h2>
    <ClientOnly>
      <div class="flex items-center space-x-3 cursor-default">
        <div
          class="h-8 w-8 overflow-hidden rounded-full ring-2 ring-gray-700 dark:ring-gray-100"
        >
          <div
            class="w-8 h-8 bg-cyan-500 rounded-full text-white flex items-center justify-center"
          >
            {{ user?.username[0].toUpperCase() }}
          </div>
        </div>
      </div>
    </ClientOnly>
  </header>
</template>
