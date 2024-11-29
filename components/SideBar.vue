<script setup>
// const router = useRouter();
// console.log(router);
</script>
<template>
  <div class="flex w-1/5 slim">
    <div class="p-2 w-full">
      <div class="flex items-center justify-between mb-6">
        <div class="flex items-center cursor-pointer">
          <IconsClipBoard />
          <h3 class="ml-2 font-bold text-lg hidden sm:block">Web Title</h3>
        </div>
      </div>
      <div>
        <h4 class="font-serif font-thin text-gray-400 mb-2 hidden sm:block">
          GENERAL
        </h4>
        <ul class="flex flex-col space-y-2">
          <NuxtLink
            :to="{ name: 'index' }"
            class="flex items-center sidebar-item hover:bg-slate-400 rounded"
          >
            <IconsCalendar class="min-w-10" />
            <li class="menu-item">Calendar</li>
          </NuxtLink>
          <NuxtLink
            :to="{ name: 'task-tracker' }"
            class="flex items-center sidebar-item hover:bg-slate-400 rounded"
          >
            <IconsTaskTracker class="min-w-10" />
            <li class="menu-item">Task Tracker</li>
          </NuxtLink>
        </ul>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Stiluri pentru sidebarul implicit */
.slim {
  min-width: 200px;
  transition: min-width 0.3s;
}

.menu-item {
  padding: 0.5rem;
  border-radius: 0.375rem;
  cursor: pointer;
  display: none;
  transition: display 0.3s;
}

/* Stiluri responsive */
@media (min-width: 640px) {
  .menu-item {
    display: block;
  }
}

/* Stiluri pentru ecrane mai mici */
@media (max-width: 639px) {
  .slim {
    min-width: 60px;
    max-width: 60px;
  }

  .menu-item {
    display: none;
  }

  /* Text afișat la hover */
  .sidebar-item:hover .menu-item {
    display: block;
    position: absolute;
    left: 65px;
    white-space: nowrap;
    background-color: #c5c9cc; /* sau orice culoare dorești */
    padding: 0.5rem;
  }
}
</style>
