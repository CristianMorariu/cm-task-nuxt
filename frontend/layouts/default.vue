<script setup>
import Topbar from "@/components/Topbar.vue";
import SideBar from "@/components/SideBar.vue";
import Dashboard from "@/components/Dashboard.vue";

const user = useUser();
console.log(user.value);
watch(user, (val) => {
  console.log("UPDATE", val);
});
const sidebarOpen = ref(true);
</script>
<template>
  <div class="flex h-screen bg-gray-50 text-gray-800">
    <SideBar :isOpen="sidebarOpen" @toggle="sidebarOpen = !sidebarOpen" />
    <div class="flex flex-col flex-1 transition-all duration-300">
      <Topbar @toggleSidebar="sidebarOpen = !sidebarOpen" />
      <main class="flex-1 overflow-y-auto p-6 md:p-10 bg-gray-50">
        <!-- <Dashboard /> -->
        <div class="content"><slot /></div>
      </main>
    </div>
  </div>
</template>

<style scoped>
.bg-color {
  background-color: #fafafa;
  /* height: 100vh; */
}
.box-shadow {
  box-shadow: 10px 10px 5px 0px rgba(0, 0, 0, 0.07);
}
</style>
