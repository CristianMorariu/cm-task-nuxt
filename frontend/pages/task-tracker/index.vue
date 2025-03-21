<script setup>
import axios from "axios";

const addTaskModal = ref(false);
const taskName = ref(null);
const habits = ref();
const currentDate = ref();
const habitTracker = ref([]);
const day = ref();
const month = ref();
const daysInMonth = ref();
const dateName = ref();

const toggleHabit = (day, habitIndex) => {
  habitTracker.value[day][habitIndex] = !habitTracker.value[day][habitIndex];
  // console.table(habitTracker.value[day][habitIndex]);
};

const createTask = () => {
  axios
    .post("http://localhost:8002/api/tasks", { name: taskName.value })
    .then((response) => {
      habits.value = response.data.data;
      addTaskModal.value = false;
      taskName.value = null;
      console.log(response.data.data);
    })
    .catch((error) => console.log(error));
  // console.log(taskName.value);
};

onMounted(() => {
  axios
    .get("http://localhost:8002/api/tasks")
    .then((response) => {
      currentDate.value = new Date(
        response.data.currentDate
      ).toLocaleDateString();
      dateName.value = response.data.dateName;
      console.log(dateName.value);
      daysInMonth.value = response.data.days_in_month;
      habits.value = response.data.data;
      console.log(daysInMonth.value, habits.value);
    })
    .catch((error) => console.log(error));
});
</script>

<template>
  <!-- <div>Daily Habit/Habit Tracker</div> -->
  <!-- <h1 class="font-bold text-3xl mb-2">Daily Habit</h1> -->
  <div class="max-w-screen-xl mx-auto">
    <div class="flex gap-10">
      <h3 class="text-gray-800 text-2xl font-bold sm:text-3xl">Daily Habit</h3>
      <button
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300"
        @click="addTaskModal = true"
      >
        <span class="text-sm">Adaugă task</span>
      </button>
    </div>
    <div class="max-w-lg">
      <!-- <p class="text-gray-600 mt-2">
          Lorem Ipsum is simply dummy text of the printing and typesetting
          industry.
        </p> -->
    </div>
    <div class="flex mt-2 justify-between">
      <div class="shadow-sm border rounded-lg overflow-x-auto">
        <table class="w-full table-auto text-sm text-left">
          <thead
            class="bg-gray-50 text-gray-600 font-medium border-b cursor-default"
          >
            <tr class="divide-x">
              <th class="py-2 px-1">Ziua</th>
              <th class="py-2 px-4" v-for="habit in habits" :key="habit.id">
                {{ habit.name }}
              </th>
            </tr>
          </thead>
          <tbody class="text-gray-600 divide-y">
            <tr v-for="day in daysInMonth" :key="day" class="divide-x hover">
              <td
                class="text-center gap-x-6 border-y border-[#ccc] cursor-default"
              >
                <span>{{ day }}</span>
              </td>

              <!-- <td
                v-for="habit in habits"
                :key="habit.id"
                class="text-center gap-x-6 border-y border-[#ccc] cursor-default"
              >
                <span>{{ habit.id }}</span>
              </td> -->

              <td class="border" v-for="habbit in habits" :key="habbit.id">
                <div
                  class="p-1 text-center"
                  @click="toggleHabit(day, habbit.id)"
                >
                  <!-- Afișează ✔️ dacă e true, ❌ dacă e false, și lasă gol dacă e null -->
                  <template v-if="habitTracker[day][habitIndex] === true"
                    >✔️</template
                  >
                  <template v-else-if="habitTracker[day][habitIndex] === false"
                    >❌</template
                  >
                  <template v-else><div class="h-5"></div></template>
                  <!-- Celulă goală pentru null -->
                </div>
              </td>

              <!-- <td class="px-6 py-4 whitespace-nowrap">{{ item.email }}</td> -->
            </tr>
          </tbody>
          <tfoot
            class="bg-gray-50 text-gray-600 font-medium border-b cursor-default"
          >
            <tr class="divide-x">
              <th class="py-2 px-1">Total</th>
              <th class="py-2 px-4" v-for="habit in habits" :key="habit.id">
                -
              </th>
            </tr>
          </tfoot>
        </table>
      </div>

      <!-- miniCalendar -->
      <div
        class="min-w-32 bg-white min-h-48 pl-4 mb-4 font-medium hidden lg:block"
      >
        <div
          class="w-32 flex-none rounded-t lg:rounded-t-none lg:rounded-l text-center shadow-lg"
        >
          <div class="block rounded-t overflow-hidden text-center">
            <div class="bg-blue-500 text-white py-1">dasd</div>
            <div class="pt-1 border-l border-r border-white bg-white">
              <span class="text-5xl font-bold leading-tight"> {{ day }} </span>
            </div>
            <div
              class="border-l border-r border-b rounded-b-lg text-center border-white bg-white -pt-2 -mb-1"
            >
              <span class="text-sm"> dsad </span>
            </div>
            <div
              class="pb-2 border-l border-r border-b rounded-b-lg text-center border-white bg-white"
            >
              <span class="text-xs leading-normal"> dsd </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div
    v-if="addTaskModal"
    id="modal"
    class="fixed inset-0 z-50 flex items-center justify-center"
  >
    <div class="fixed inset-0 bg-black/50"></div>
    <div
      class="relative w-full max-w-md p-6 bg-white dark:bg-gray-800 rounded-lg shadow-xl"
    >
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
          Add a task
        </h3>
        <button
          @click="addTaskModal = false"
          id="closeModalButton"
          class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200"
        >
          <svg
            class="h-4 w-4 inline-block ml-2"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            aria-hidden="true"
            data-slot="icon"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M6 18 18 6M6 6l12 12"
            ></path>
          </svg>
        </button>
      </div>

      <div class="space-y-4">
        <div>
          <label
            for="name"
            class="block text-sm font-medium text-gray-700 dark:text-gray-300"
            >Name</label
          >
          <input
            v-model="taskName"
            type="text"
            id="name"
            class="w-full mt-1 p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500"
            required
          />
        </div>

        <div class="flex justify-end gap-3">
          <button
            @click="addTaskModal = false"
            id="cancelButton"
            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600"
          >
            Cancel
          </button>
          <button
            id="submitUrlButton"
            class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition duration-300"
            @click="createTask()"
            type="submit"
          >
            Confirm
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.border {
  border: 1px solid #ccc;
  cursor: pointer;
}
.hover {
  cursor: pointer;
  transition: transform 0.3s ease, opacity 0.3s ease;
}
.hover:hover {
  background-color: #f0f0f0;
}
</style>
