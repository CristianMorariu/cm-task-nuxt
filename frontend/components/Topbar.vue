<script setup></script>
<template>
  <header
    class="flex items-center justify-between px-4 md:px-8 py-3 bg-white border-b border-gray-200 shadow-sm"
  >
    <button class="text-gray-600 text-xl" @click="$emit('toggleSidebar')">
      ☰
    </button>

    <h2 class="text-lg font-semibold">Dashboard</h2>

    <div class="flex items-center space-x-3">
      <div
        class="w-8 h-8 bg-cyan-500 rounded-full text-white flex items-center justify-center"
      >
        T
      </div>
    </div>
  </header>
</template>
