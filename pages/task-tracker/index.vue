<script setup>
const today = new Date();
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
// console.log(weekday); // ex: "luni"
// console.log(day); // ex: "18"
// console.log(month); // ex: "decembrie"
function capitalizeFirstLetter(val) {
  return String(val).charAt(0).toUpperCase() + String(val).slice(1);
}
const numDays = (y, m) => new Date(y, m, 0).getDate();
console.log(month);
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
  { id: 3, name: "Meditatiedsa " },
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
console.log(numberOfHabits);

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

  // console.log(habitTracker.value[dayIndex][habitIndex]);
};
</script>

<template>
  <!-- <div>Daily Habit/Habit Tracker</div> -->
  <!-- <h1 class="font-bold text-3xl mb-2">Daily Habit</h1> -->
  <div class="max-w-screen-xl mx-auto">
    <div class="max-w-lg">
      <h3 class="text-gray-800 text-2xl font-bold sm:text-3xl">Daily Habit</h3>
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
