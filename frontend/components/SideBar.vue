<script setup>
import axios from "@/axios";
const auth = useAuth();

const prop = defineProps(["isOpen"]);
// console.log(prop);
</script>
<template>
  <aside
    :class="[
      'bg-[#212934] h-full slim border-r border-gray-200 flex flex-col justify-between  md:static z-40 transition-all duration-300',
      prop.isOpen ? 'min-w-64 ' : 'min-w-20',
    ]"
  >
    <div class="overflow-hidden">
      <div class="flex items-center justify-between md:px-8 md:py-3 px-1 py-6">
        <!-- <h1 class="text-xl font-bold text-amber-600" v-if="true"></h1> -->
        <img
          src="@/assets/Logo.png"
          alt="Logo"
          class="w-auto h-auto hidden md:block"
        />
        <img
          src="@/assets/logo_mini.svg"
          alt="Logo"
          class="w-auto h-auto block md:hidden"
        />
      </div>
      <nav class="">
        <div class="flex flex-col items-stretch">
          <NuxtLink
            :to="{ name: 'index' }"
            class="flex items-center gap-2 w-full px-4 py-2 rounded-sm hover_class sidebar-item"
          >
            <IconsKeyboardOpen class="w-5 h-5" />
            <span class="menu-item">Dashboard</span>
          </NuxtLink>

          <NuxtLink
            :to="{ name: 'task-tracker' }"
            class="flex items-center gap-2 w-full px-4 py-2 rounded-sm hover_class sidebar-item"
          >
            <IconsUsers class="w-5 h-5" />
            <span class="menu-item">Users</span>
          </NuxtLink>

          <NuxtLink
            :to="{ name: 'index' }"
            class="flex items-center gap-2 w-full px-4 py-2 rounded-sm hover_class sidebar-item"
          >
            <IconsProjects class="w-5 h-5" />
            <span class="menu-item">Projects</span>
          </NuxtLink>

          <NuxtLink
            :to="{ name: 'index' }"
            class="flex items-center gap-2 w-full px-4 py-2 rounded-sm hover_class sidebar-item"
          >
            <IconsTasks class="w-5 h-5" />
            <span class="menu-item">My tasks</span>
          </NuxtLink>

          <NuxtLink
            :to="{ name: 'index' }"
            class="flex items-center gap-2 w-full px-4 py-2 rounded-sm hover_class sidebar-item"
          >
            <IconsProfile class="w-5 h-5" />
            <span class="menu-item">Profile</span>
          </NuxtLink>

          <button
            @click="auth.logout"
            class="flex items-center gap-2 w-full px-4 py-2 rounded-sm hover_class sidebar-item"
          >
            <IconsLogout class="w-5 h-5" />
            <span class="menu-item">Logout</span>
          </button>
        </div>
      </nav>
    </div>
  </aside>
</template>

<style scoped>
/* Stiluri pentru sidebarul implicit */
.sidebar-height {
  height: calc(100%-40px);
}
/* .nav-list {
  display: flex;
  flex-direction: column;
  justify-content: center;
} */
.slim {
  min-width: 200px;
  transition: min-width 0.3s;
}
.hover_class:hover {
  background: linear-gradient(90deg, #212934 0%, #5f6b7a 100%);
}

.menu-item {
  padding: 0.5rem;
  border-radius: 0.375rem;
  cursor: pointer;
  display: none;
  transition: display 0.3s;
  color: white;
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
