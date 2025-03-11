<script setup></script>
<template>
  <div class="px-5 py-7 border rounded-md mb-5 w-100">
    <div class="inline-flex justify-center align-center">
      <button>Pomo<span class="textbutton cursor-pointer">doro</span></button>
      <button>
        Short
        <span class="textbutton cursor-pointer">Break</span>
      </button>
      <button>
        Long
        <span class="textbutton cursor-pointer">Break</span>
      </button>
    </div>
  </div>
</template>

<style scoped>
@media screen and (max-width: 350px) {
  .textbutton {
    display: none;
  }
}
button {
  border: none;
  margin: 0px;
  border-radius: 4px;
  font-family: ArialRounded;
  font-size: 16px;
  padding: 2px 12px;
  height: 28px;
  cursor: pointer;
  background: none rgba(0, 0, 0, 0.15);
  box-shadow: none;
  color: white;
  opacity: 1;
  font-weight: bold;
}
</style>
