<script setup>
import axios from "@/axios";

const router = useRouter();
// console.log(router.getRoutes());
const logout = () => {
  axios
    .post("/logout")
    .then((response) => {
      console.log(response);
      router.push({ name: "auth-login" });
    })
    .catch((err) => {
      console.log(err);
    });
};
const prop = defineProps(["isOpen"]);
// console.log(prop);
</script>
<template>
  <!-- <div class="flex w-1/6 slim">
    <div class="p-2 w-full flex flex-col justify-between">
      <div class="flex flex-col justify-between mb-6">
        <div class="flex items-center cursor-pointer">
          <IconsClipBoard />
          <h3 class="ml-2 font-bold text-lg hidden md:block">
            {{ true ? "Task Tracker" : "Capacity" }}
          </h3>
        </div>
        <div class="mt-8">
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

      <div class="py-3 border-y-2 border-gray-200 max-w-[200px]">
        <div class="flex gap-4">
          <img
            class="h-12 w-12 shrink-0 rounded-lg object-cover"
            src="https://lh3.googleusercontent.com/a/AGNmyxbSlMgTRzE3_SMIxpDAhpNad-_CN5_tmph1NQ1KhA=s96-c"
            alt=""
          />
          <div class="flex flex-col gap-1">
            <a href="#" class="font-semibold text-black hover:text-blue-600"
              >Prajwal Hallale</a
            >

            <button @click="logout">logOut</button>
          </div>
        </div>
      </div>
    </div>
  </div> -->
  <aside
    :class="[
      'bg-[#212934] h-full slim border-r border-gray-200 flex flex-col justify-between  md:static z-40 transition-all duration-300',
      prop.isOpen ? 'w-64 ' : 'w-15',
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
            class="flex items-center gap-2 w-full px-4 py-2 rounded-md hover_class sidebar-item"
          >
            <IconsKeyboardOpen class="w-5 h-5" />
            <span class="menu-item">Dashboard</span>
          </NuxtLink>

          <NuxtLink
            :to="{ name: 'task-tracker' }"
            class="flex items-center gap-2 w-full px-4 py-2 rounded-md hover_class sidebar-item"
          >
            <IconsUsers class="w-5 h-5" />
            <span class="menu-item">Users</span>
          </NuxtLink>

          <NuxtLink
            :to="{ name: 'index' }"
            class="flex items-center gap-2 w-full px-4 py-2 rounded-md hover_class sidebar-item"
          >
            <IconsProjects class="w-5 h-5" />
            <span class="menu-item">Projects</span>
          </NuxtLink>

          <NuxtLink
            :to="{ name: 'index' }"
            class="flex items-center gap-2 w-full px-4 py-2 rounded-md hover_class sidebar-item"
          >
            <IconsTasks class="w-5 h-5" />
            <span class="menu-item">My tasks</span>
          </NuxtLink>

          <NuxtLink
            :to="{ name: 'index' }"
            class="flex items-center gap-2 w-full px-4 py-2 rounded-md hover_class sidebar-item"
          >
            <IconsProfile class="w-5 h-5" />
            <span class="menu-item">Profile</span>
          </NuxtLink>

          <NuxtLink
            :to="{ name: 'index' }"
            class="flex items-center gap-2 w-full px-4 py-2 rounded-md hover_class sidebar-item"
          >
            <IconsLogout class="w-5 h-5" />
            <span class="menu-item">Logout</span>
          </NuxtLink>
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
