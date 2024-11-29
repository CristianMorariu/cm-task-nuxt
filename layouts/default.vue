<script setup></script>
<template>
  <!-- py-2 pr-2 -->
  <div class="flex bg-color min-h-screen p-2">
    <SideBar />
    <div class="flex-grow border bg-white rounded-lg box-shadow p-4">
      <div class="flex justify-between">
        <nav class="flex mb-5" aria-label="Breadcrumb">
          <ol class="inline-flex items-center space-x-1 md:space-x-2">
            <li class="inline-flex items-center">
              <a
                href="#"
                class="text-gray-700 hover:text-gray-900 inline-flex items-center"
              >
                <svg
                  class="w-5 h-5 mr-2.5"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                  ></path>
                </svg>
                Home
              </a>
            </li>
            <li>
              <div class="flex items-center">
                <svg
                  class="w-6 h-6 text-gray-400"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                    clip-rule="evenodd"
                  ></path>
                </svg>
                <a
                  href="#"
                  class="text-gray-700 hover:text-gray-900 ml-1 md:ml-2 text-sm font-medium"
                  >Users</a
                >
              </div>
            </li>
            <li>
              <div class="flex items-center">
                <svg
                  class="w-6 h-6 text-gray-400"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    fill-rule="evenodd"
                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                    clip-rule="evenodd"
                  ></path>
                </svg>
                <span
                  class="text-gray-400 ml-1 md:ml-2 text-sm font-medium"
                  aria-current="page"
                  >List</span
                >
              </div>
            </li>
          </ol>
        </nav>
        <!-- user -->
        <div class="flex items-center border rounded-lg p-2 h-16">
          <div class="relative">
            <img
              class="h-12 w-12 rounded-md object-cover"
              src="https://randomuser.me/api/portraits/women/87.jpg"
              alt="Avatar"
            />
            <div class="absolute inset-0 rounded-full shadow-inner"></div>
          </div>
          <div class="ml-4">
            <h2 class="font-bold text-gray-800 text-lg">Jane Doe</h2>
            <p class="text-sm font text-gray-600">Software Engineer</p>
          </div>
        </div>
      </div>
      <slot />
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
