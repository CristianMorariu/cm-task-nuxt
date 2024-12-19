<script setup>
//https://memento-mori-calendar.netlify.app/
const dataNastere = ref("2000-10-08");
const decadesLived = ref(0);
const leftWeeksLived = ref(0);

function calculateWeeks(birthDate) {
  const now = new Date();
  const birth = new Date(birthDate);
  const differenceInTime = now - birth;

  // Conversie la săptămâni
  const differenceInWeeks = Math.floor(
    differenceInTime / (1000 * 60 * 60 * 24 * 7)
  );

  decadesLived.value = Math.floor(differenceInWeeks / 520);
  leftWeeksLived.value = Math.floor(differenceInWeeks % 520);
  // console.log(decadesLived.value, leftWeeksLived.value);
}

watch(dataNastere, (val) => {
  calculateWeeks(val);
  console.log(val);
});
if (dataNastere.value) calculateWeeks(dataNastere.value);
const isEnabled = (decade, week) => {
  return (
    decadesLived.value > 8 ||
    decadesLived.value >= decade ||
    (decade === decadesLived.value + 1 && leftWeeksLived.value >= week)
  );
};

const computedWeeks = computed(() => {
  return Array.from({ length: 520 }, (_, i) => {
    const isDecadeBreak = i % 26 === 0 && i % 52 !== 0;
    const isEnabled =
      decadesLived.value > 8 ||
      decadesLived.value >= nrOfDecades ||
      (nrOfDecades === decadesLived.value + 1 && leftWeeksLived.value >= i);
    return { isDecadeBreak, isEnabled };
  });
});
</script>

<template>
  <div class="flex gap-10">
    <h1 class="text-gray-800 text-2xl font-bold sm:text-3xl">Calendar</h1>
    <input
      v-model="dataNastere"
      type="date"
      name="dataNastere"
      id="dataNastere"
    />
  </div>

  <div class="calendar">
    <div class="decade" v-for="nrOfDecades in 8" :key="nrOfDecades">
      <div class="decade-weeks">
        <div
          v-for="week in 520"
          :key="week"
          class="square"
          :class="{
            enabled: isEnabled(nrOfDecades, week),
            'decade-break': week % 26 === 0 && week % 52 !== 0,
          }"
        ></div>
      </div>
      <div class="line-numbers">
        <span></span>
        <span class="h-5">{{ nrOfDecades * 10 - 5 }}</span>
        <span class="h-5">{{ nrOfDecades * 10 }}</span>
      </div>
    </div>
  </div>
</template>

<style scoped>
.calendar {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 10px;
  box-sizing: border-box;
}
.decade {
  display: flex;
  margin-bottom: 20px;
}
.decade-weeks {
  display: grid;
  grid-template-columns: repeat(52, auto);
  row-gap: 4px;
  column-gap: 4px;
}
.decade-break {
  margin-right: 20px;
}
.square {
  width: 14px;
  height: 14px;
  border: 1px solid #000;
  border-radius: 0.125rem /* 2px */;
}

.enabled {
  background-color: #2f4f4f;
}
.line-numbers {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  margin-left: 6px;
}

@media screen and (max-width: 1200px) {
  .decade-weeks {
    grid-template-columns: repeat(13, auto);
    -moz-column-gap: 12px;
    column-gap: 12px;
  }
}
@media screen and (max-width: 1200px) {
  .line-numbers {
    margin-left: 0;
  }
  .decade-break {
    margin-right: 6px;
  }
}
</style>
