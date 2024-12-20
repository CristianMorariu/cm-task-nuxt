<script setup>
//https://memento-mori-calendar.netlify.app/
// https://memento-mori-calendar.vercel.app/
const dataNastere = ref("2000-01-21");
const nrOfDecades = 8;
const decadesLived = ref(0);
const leftWeeksLived = ref(0);
const leftToLive = ref();

function calculateWeeks(birthDate) {
  const now = new Date();
  const birth = new Date(birthDate);
  const differenceInTime = now - birth;
  // const differenceInWeeks = Math.floor(
  //   differenceInTime / (1000 * 60 * 60 * 24 * 7)
  // );
  // console.log(differenceInWeeks);
  // Milisecunde într-un deceniu (10 ani * 365.25 zile/an * 24h * 60m * 60s * 1000ms)
  const millisecondsInDecade = 10 * 365.25 * 24 * 60 * 60 * 1000;
  // Milisecunde într-o săptămână (7 zile * 24h * 60m * 60s * 1000ms)
  const millisecondsInWeek = 7 * 24 * 60 * 60 * 1000;
  // Calculăm deceniile trăite
  decadesLived.value = Math.floor(differenceInTime / millisecondsInDecade);
  // Calculăm milisecundele rămase după deceniile trăite
  const remainingMilliseconds = differenceInTime % millisecondsInDecade;
  // Calculăm săptămânile rămase
  leftWeeksLived.value = Math.floor(remainingMilliseconds / millisecondsInWeek);
  // console.log(decadesLived.value, leftWeeksLived.value);
  let weeksSpent = decadesLived.value * 520 + leftWeeksLived.value;
  // console.log(weeksSpent);
  leftToLive.value = nrOfDecades * 520 - weeksSpent;
  console.log(leftToLive.value);
}

watch(dataNastere, (val) => {
  calculateWeeks(val);
  console.log(val);
});
if (dataNastere.value) calculateWeeks(dataNastere.value);
const isEnabled = (decade, week) => {
  return (
    decadesLived.value >= decade ||
    (decade === decadesLived.value + 1 && leftWeeksLived.value > week)
  );
};
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
  <p class="text-gray-600 mt-2 text-center">
    Mai ai ≈ <span class="font-bold">{{ leftToLive }}</span> săptamani de trait.
  </p>

  <div class="calendar">
    <div class="decade" v-for="decade in nrOfDecades" :key="decade">
      <div class="decade-weeks">
        <div
          v-for="week in 520"
          :key="week"
          class="square"
          :class="{
            enabled: isEnabled(decade, week),
            'decade-break': week % 26 === 0 && week % 52 !== 0,
          }"
        ></div>
      </div>
      <div class="line-numbers">
        <span></span>
        <span class="h-5">{{ decade * 10 - 5 }}</span>
        <span class="h-5">{{ decade * 10 }}</span>
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
  row-gap: 5px;
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
