<script setup>
import axios from "@/axios";

const router = useRouter();
definePageMeta({
  layout: "auth-layout",
});
const user = useUser();
const form = reactive({
  email: "admin@gmail.com",
  password: "Password",
});
const errors = ref({});

async function handleSubmit() {
  console.log(form);
  try {
    const response = await axios.post("/login", form);
    console.log(response);
    localStorage.setItem("access_token", response.data.token);
    localStorage.setItem("user", JSON.stringify(response.data.data));
    user.value = response.data.data;
    console.log(user.value);
    router.push({ name: "task-tracker" });
  } catch (error) {
    // console.log("Network error: " + error);
    console.log(error);
    errors.value = error.response.data.errors;
  } finally {
    // form.password = "";
    // form.password_confirmation = "";
  }
}
</script>
<template>
  <form @submit.prevent="handleSubmit" class="login-form">
    <label for="username">Enter Email </label>
    <input
      v-model="form.email"
      type="email"
      id="username"
      placeholder="Email"
    />
    <div v-if="errors.email" style="color: orangered">
      {{ errors.email[0] }}
    </div>
    <label for="password">Enter Password</label>
    <input
      v-model="form.password"
      type="password"
      id="password"
      placeholder="Password"
      autocomplete="off"
    />

    <div class="remember-me">
      <input type="checkbox" id="remember" />
      <div for="remember">Keep me logged in</div>
    </div>

    <button class="login-btn">LOG IN</button>
    <div class="flex justify-center mt-8">
      <hr class="w-24" />
    </div>
    <NuxtLink to="/auth/register" class="create-account">
      Create account
    </NuxtLink>
    <div class="recover-password">Recover password</div>
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

input[type="email"],
input[type="password"] {
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

input[type="email"]:focus,
input[type="password"]:focus {
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

/* Link-ul Recover Password */
.recover-password {
  margin-top: 15px;
  font-size: 14px;
  color: #ff5733;
  text-decoration: none;
}

.recover-password:hover {
  text-decoration: underline;
}
.create-account {
  margin-top: 15px;
  font-size: 14px;
  color: #ffbf00;
  text-decoration: none;
}

.create-account:hover {
  text-decoration: underline;
}
</style>
