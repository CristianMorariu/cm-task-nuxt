<script setup>
import axios from "@/axios";

definePageMeta({
  layout: "auth-layout",
});

const data = ref({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

onMounted(() => {
  axios
    .get("/projects")
    .then((response) => {
      console.log(response);
    })
    .catch((error) => console.log(error));
});

const submit = () => {
  console.log(data.value);
  axios
    .post("/register", data.value)
    .then((response) => {
      console.log(response);
    })
    .catch((error) => console.log(error));
};
</script>
<template>
  <!-- <pre>{{ data }}</pre> -->
  <form @submit.prevent="submit" class="login-form">
    <label for="name">Enter Name </label>
    <input v-model="data.name" type="text" id="name" placeholder="Name" />
    <label for="username">Enter Email </label>
    <input
      v-model="data.email"
      type="email"
      id="username"
      placeholder="Email"
    />
    <label for="password">Enter Password</label>
    <input
      v-model="data.password"
      type="password"
      id="password"
      placeholder="Password"
      autocomplete="off"
    />
    <label for="passwordConfirmation">Repeat Password</label>
    <input
      v-model="data.password_confirmation"
      type="password"
      id="passwordConfirmation"
      placeholder="Repeat Password"
      autocomplete="off"
    />

    <!-- <div class="remember-me">
      <input type="checkbox" id="remember" />
      <div for="remember">Keep me logged in</div>
    </div> -->

    <button class="login-btn">REGISTER</button>

    <!-- <NuxtLink to="/auth/register" class="create-account">
      Create account
    </NuxtLink> -->
    <!-- <div class="recover-password">Recover password</div> -->
  </form>
</template>

<style scoped>
.login-form {
  display: flex;
  padding: 50px;
  flex-direction: column;
  align-items: center;
}

label {
  display: flex;
  justify-content: center;
  font-size: 14px;
  margin-bottom: 5px;
  width: 100%;
  text-align: left;
  color: #555;
}

input {
  width: 100%;
  padding: 12px;
  margin-bottom: 15px;
  border: 1px solid #ccc;
  border-radius: 25px;
  text-align: center;
  font-size: 14px;
  outline: none;
  transition: border 0.3s;
}

input:focus {
  border-color: #ffbf00;
}

/* Checkbox-ul și label-ul */
.remember-me {
  display: flex;
  align-items: center;
  width: 100%;
  margin-bottom: 15px;
}

.remember-me input {
  margin-right: 8px;
  width: 16px;
  height: 16px;
  accent-color: #ffbf00;
}

/* Butonul LOGIN */
.login-btn {
  width: 100%;
  padding: 12px;
  background-color: #ffbf00;
  color: white;
  border: none;
  border-radius: 25px;
  font-size: 14px;
  cursor: pointer;
  text-transform: uppercase;
  font-weight: bold;
  transition: background 0.3s;
}

.login-btn:hover {
  background-color: #e6a500;
}
</style>
