<script setup>
//https://memento-mori-calendar.netlify.app/
// https://memento-mori-calendar.vercel.app/
// const dataNastere = ref("2000-01-21");
const dataNastere = ref(null);
const now = new Date();
const nrOfDecades = 8;
const decadesLived = ref(0);
const leftWeeksLived = ref(0);
const leftToLive = ref();
let isYourBirthday;

function calculateWeeks(birthDate) {
  const birth = new Date(birthDate);
  isYourBirthday =
    now.getMonth() == birth.getMonth() && now.getDate() == birth.getDate()
      ? true
      : false;

  const differenceInTime = now - birth;
  // const differenceInWeeks = Math.floor(differenceInTime / (1000 * 60 * 60 * 24 * 7));
  // Milisecunde într-un deceniu (10 ani * 365.25 zile/an * 24h * 60m * 60s * 1000ms)
  const millisecondsInDecade = 10 * 365.25 * 24 * 60 * 60 * 1000;
  const millisecondsInWeek = 7 * 24 * 60 * 60 * 1000; // Milisecunde într-o săptămână
  decadesLived.value = Math.floor(differenceInTime / millisecondsInDecade); //deceniile trăite
  const remainingMilliseconds = differenceInTime % millisecondsInDecade; //milisecundele rămase după deceniile trăite
  leftWeeksLived.value = Math.floor(remainingMilliseconds / millisecondsInWeek); //săptămânile rămase
  let weeksSpent = decadesLived.value * 520 + leftWeeksLived.value;
  // console.log((leftWeeksLived.value % 52) - 1); //saptamani traite din anul curent
  leftToLive.value = nrOfDecades * 520 - weeksSpent;
}

watch(dataNastere, (val) => {
  calculateWeeks(val);
  // console.log(val);
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
  <div v-if="dataNastere">
    <p class="text-gray-600 mt-2 text-center">
      Mai sunt
      <!--<pre>{{ leftWeeksLived %52 }}</pre>-->
      <span class="font-bold">{{ 52 - ((leftWeeksLived % 52) - 1) }}</span> de
      săptămâni până la ziua ta
    </p>
    <p v-if="!isYourBirthday" class="text-gray-600 mt-2 text-center">
      și <span class="font-bold">≈ {{ leftToLive }}</span> de săptamani de
      trait.
    </p>
    <p v-else class="text-gray-600 mt-2 text-center">
      <span class="font-extrabold text-3xl"
        >La mulți ani!{{ "\u{1F973}" }}</span
      >
    </p>
  </div>
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
