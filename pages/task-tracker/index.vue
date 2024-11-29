<script setup>
const today = new Date().toString();
console.log(today);
// Funcție pentru a obține numărul de zile dintr-o lună
const numDays = (y, m) => new Date(y, m, 0).getDate();

let year = 2024;
let month = 2;
let numberOfDays = numDays(year, month);
// let daysInMonth = Array.from({ length: numberOfDays }, (_, i) => i + 1); // Ex: 30 zile în luna curentă

// let numberOfHabit = 4;
const habitTracker = ref([]);
const habits = ref([
  { id: 1, name: "Exercitii" },
  { id: 2, name: "Citit" },
  { id: 3, name: "Meditatie" },
]);
const numberOfHabits = habits.value.length; // Schimbat pentru a folosi length corect
console.log(numberOfHabits);

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
};
</script>

<template>
  <!-- <div>Daily Habit/Habit Tracker</div> -->
  <div class="flex">
    <h1 class="font-bold text-4xl">Daily Habit</h1>
    <div><span>Month:</span></div>
    <div><span>Year:</span></div>
  </div>
  <table class="table-fixed">
    <thead>
      <tr>
        <th class="border">Ziua</th>
        <!-- Afișează numele fiecărui obicei -->
        <th class="border" v-for="habit in habits" :key="habit.id">
          {{ habit.name }}
        </th>
      </tr>
    </thead>

    <!-- Parcurge zilele și obiceiurile -->
    <tbody>
      <tr v-for="(day, dayIndex) in habitTracker" :key="dayIndex">
        <td class="border">
          <!-- daca pun border pe divul din td arata exact ca in excel cu cell-uri -->
          <div class="p-1">{{ dayIndex + 1 }}</div>
        </td>
        <td class="border" v-for="(habit, habitIndex) in day" :key="habitIndex">
          <div
            class="p-1 hover max-w-28 min-w-14"
            @click="toggleHabit(dayIndex, habitIndex)"
          >
            <!-- Afișează ✔️ dacă e true, ❌ dacă e false, și lasă gol dacă e null -->
            <template v-if="habitTracker[dayIndex][habitIndex] === true"
              >✔️</template
            >
            <template v-else-if="habitTracker[dayIndex][habitIndex] === false"
              >❌</template
            >
            <template v-else><div class="p-2 m-1 hover"></div></template>
            <!-- Celulă goală pentru null -->
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<style scoped>
.border {
  border: 1px solid #ccc;
}
.hover {
  cursor: pointer;
  transition: background-color 0.3s ease;
}
.hover:hover {
  background-color: #f0f0f0;
}
</style>
