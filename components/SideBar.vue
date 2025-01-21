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
          <h3 class="ml-2 font-bold text-lg hidden md:block">
            {{ true ? "Task Tracker" : "Capacity" }}
          </h3>
        </div>
      </div>
      <div>
        <h4 class="font-serif font-thin text-gray-400 mb-2 hidden md:block">
          GENERAL
        </h4>
        <ul class="flex flex-col space-y-2">
          <NuxtLink
            :to="{ name: 'index' }"
            class="flex items-center sidebar-item hover:bg-slate-400 rounded"
            active-class="bg-slate-300"
          >
            <IconsCalendar class="min-w-10" />
            <li class="menu-item">Calendar</li>
          </NuxtLink>
          <NuxtLink
            :to="{ name: 'pomo-tracker' }"
            class="flex items-center sidebar-item hover:bg-slate-400 rounded"
            active-class="bg-slate-300"
          >
            <IconsTomato class="min-w-10" />
            <li class="menu-item">Pomo Tracker</li>
          </NuxtLink>
          <NuxtLink
            :to="{ name: 'task-tracker' }"
            class="flex items-center sidebar-item hover:bg-slate-400 rounded"
            active-class="bg-slate-300"
          >
            <IconsTaskTracker class="min-w-10" />
            <li class="menu-item">Task Tracker</li>
          </NuxtLink>
          <NuxtLink
            :to="{ name: 'useful-websites' }"
            class="flex items-center sidebar-item hover:bg-slate-400 rounded"
            active-class="bg-slate-300"
          >
            <IconsWebsite class="min-w-10" />
            <li class="menu-item">Useful Website</li>
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
@media (min-width: 768px) {
  .menu-item {
    display: block;
  }
}

/* Stiluri pentru ecrane mai mici */
@media (max-width: 767px) {
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
