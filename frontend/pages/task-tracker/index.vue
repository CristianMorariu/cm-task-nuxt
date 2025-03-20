<script setup>
import axios from "axios";

const addTaskModal = ref(false);
const taskName = ref(null);
const today = new Date();
// console.log(today);
const formatter = new Intl.DateTimeFormat("ro", {
  weekday: "long", // Pentru "Luni", "Marți", etc.
  day: "numeric", // Pentru ziua lunii
  month: "long", // Pentru luna (ex. "ianuarie")
});
const { weekday, day, month } = formatter
  .formatToParts(today)
  .reduce((acc, part) => {
    acc[part.type] = part.value;
    return acc;
  }, {});

function capitalizeFirstLetter(val) {
  return String(val).charAt(0).toUpperCase() + String(val).slice(1);
}
const numDays = (y, m) => new Date(y, m, 0).getDate();
// console.log(month);
let year = 2024;
let month1 = 2;
let numberOfDays = numDays(year, month1);
// let daysInMonth = Array.from({ length: numberOfDays }, (_, i) => i + 1); // Ex: 30 zile în luna curentă

// let numberOfHabit = 4;
const habitTracker = ref([]);
const habits = ref([
  { id: 1, name: "Exercitii" },
  { id: 2, name: "Citit" },
  { id: 3, name: "Meditatie DEdfADe" },
  { id: 4, name: "Meditatie dasdasdad" },
  // { id: 3, name: "Meditatiedsa " },
  // { id: 3, name: "Meditatie gdfgd ffsd sdfsfssdf" },
  // { id: 3, name: "Meditatiefsdf s d hfewwwwwwwwww" },
  // { id: 3, name: "Meditatiefsdf s d hfewwwwwwwwww" },
  // { id: 3, name: "Meditatiefsdf s d hfewwwwwwwwww" },
  // { id: 3, name: "Meditatiefsdf s d hfewwwwwwwwww" },
  // { id: 4, name: "Meditatiefsdf s d hfewwwwwwwwww" },
  // { id: 5, name: "Meditatiefsdf s d hfewwwwwwwwww" },
  // { id: 6, name: "Meditatiefsdf s d hfewwwdasadadaswwwwwww" },
]);
const numberOfHabits = habits.value.length; // Schimbat pentru a folosi length corect
// console.log(numberOfHabits);

watch(habitTracker.value, (val) => {
  // console.table(val);
});

for (let i = 0; i < numberOfDays; i++) {
  habitTracker.value[i] = [];
  for (let j = 0; j < numberOfHabits; j++) {
    habitTracker.value[i][j] = null;
  }
}

// Funcția pentru a alterna valoarea unui obicei
const toggleHabit = (dayIndex, habitIndex) => {
  habitTracker.value[dayIndex][habitIndex] =
    !habitTracker.value[dayIndex][habitIndex];

  // console.table(habitTracker.value[dayIndex][habitIndex]);
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
      habits.value = response.data.data;
      console.log(habits.value);
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
    <div class="flex mt-4 justify-between">
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
            <tr
              v-for="(day, dayIndex) in habitTracker"
              :key="dayIndex"
              class="divide-x hover"
            >
              <td
                class="text-center gap-x-6 border-y border-[#ccc] cursor-default"
              >
                <span>{{ dayIndex + 1 }}</span>
              </td>
              <!-- <td class="px-6 py-4 whitespace-nowrap">{{ item.email }}</td> -->
              <td
                class="border"
                v-for="(habit, habitIndex) in day"
                :key="habitIndex"
              >
                <div
                  class="p-1 text-center"
                  @click="toggleHabit(dayIndex, habitIndex)"
                >
                  <!-- Afișează ✔️ dacă e true, ❌ dacă e false, și lasă gol dacă e null -->
                  <template v-if="habitTracker[dayIndex][habitIndex] === true"
                    >✔️</template
                  >
                  <template
                    v-else-if="habitTracker[dayIndex][habitIndex] === false"
                    >❌</template
                  >
                  <template v-else><div class="h-5"></div></template>
                  <!-- Celulă goală pentru null -->
                </div>
              </td>
            </tr>
          </tbody>
          <tfoot
            class="bg-gray-50 text-gray-600 font-medium border-b cursor-default"
          >
            <tr class="divide-x">
              <th class="py-2 px-1">Total</th>
              <th class="py-2 px-4" v-for="habit in habits" :key="habit.id">
                {{ habit.name }}
              </th>
            </tr>
          </tfoot>
        </table>
      </div>

      <!-- <table class="table-fixed">
      <thead>
        <tr>
          <th class="border">Ziua</th>
          <th
            class="border w-32 min-w-28"
            v-for="habit in habits"
            :key="habit.id"
          >
            {{ habit.name }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(day, dayIndex) in habitTracker" :key="dayIndex">
          <td class="border max-w-8">
            <div class="p-1 w-14">{{ dayIndex + 1 }}</div>
          </td>
          <td
            class="border"
            v-for="(habit, habitIndex) in day"
            :key="habitIndex"
          >
            <div class="p-1 hover" @click="toggleHabit(dayIndex, habitIndex)">
              <template v-if="habitTracker[dayIndex][habitIndex] === true"
                >✔️</template
              >
              <template v-else-if="habitTracker[dayIndex][habitIndex] === false"
                >❌</template
              >
              <template v-else><div class="p-2 m-1 hover"></div></template>
            </div>
          </td>
        </tr>
      </tbody>
    </table> -->
      <!-- miniCalendar -->
      <div
        class="min-w-32 bg-white min-h-48 pl-4 mb-4 font-medium hidden lg:block"
      >
        <div
          class="w-32 flex-none rounded-t lg:rounded-t-none lg:rounded-l text-center shadow-lg"
        >
          <div class="block rounded-t overflow-hidden text-center">
            <div class="bg-blue-500 text-white py-1">
              {{ capitalizeFirstLetter(weekday) }}
            </div>
            <div class="pt-1 border-l border-r border-white bg-white">
              <span class="text-5xl font-bold leading-tight"> {{ day }} </span>
            </div>
            <div
              class="border-l border-r border-b rounded-b-lg text-center border-white bg-white -pt-2 -mb-1"
            >
              <span class="text-sm"> {{ capitalizeFirstLetter(month) }} </span>
            </div>
            <div
              class="pb-2 border-l border-r border-b rounded-b-lg text-center border-white bg-white"
            >
              <span class="text-xs leading-normal">
                {{ today.getFullYear() }}
              </span>
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
