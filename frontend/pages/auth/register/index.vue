<script setup>
import axios from "@/axios";

definePageMeta({
  layout: "auth-layout",
  authTitle: "Welcome at",
});
const router = useRouter();
const form = reactive({
  username: "Admin",
  email: "admin@gmail.com",
  password: "Password",
  password_confirmation: "Password",
});
const errors = ref({});

onMounted(() => {
  axios
    .get("/projects")
    .then((response) => {
      console.log(response);
    })
    .catch((error) => console.log(error));
});

async function handleSubmit() {
  // console.log(form);
  try {
    const response = await axios.post("/register", form);
    console.log(response);
    localStorage.setItem("access_token", response.data.token);
    router.push({ username: "task-tracker" });
  } catch (error) {
    // console.log("Network error: " + error);
    console.log(error);
    errors.value = error.response.data.errors ?? {
      message: error.response.data.message,
    };
  } finally {
    // form.password = "";
    // form.password_confirmation = "";
  }
}
</script>
<template>
  <!-- <pre>{{ data }}</pre> -->
  <form @submit.prevent="handleSubmit" class="login-form">
    <label for="username">Enter Username </label>
    <input
      v-model="form.username"
      type="text"
      id="username"
      placeholder="Name"
    />
    <div v-if="errors.username" style="color: orangered">
      {{ errors.username[0] }}
    </div>
    <label for="email">Enter Email </label>
    <input v-model="form.email" type="email" id="email" placeholder="Email" />
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
    <div v-if="errors.password" style="color: orangered">
      {{ errors.password[0] }}
    </div>
    <label for="passwordConfirmation">Repeat Password</label>
    <input
      v-model="form.password_confirmation"
      type="password"
      id="passwordConfirmation"
      placeholder="Repeat Password"
      autocomplete="off"
    />
    <div v-if="errors.message" style="color: orangered">
      {{ errors?.message }}
    </div>
    <!-- <div class="remember-me">
      <input type="checkbox" id="remember" />
      <div for="remember">Keep me logged in</div>
    </div> -->

    <button class="login-btn">REGISTER</button>

    <!-- <NuxtLink to="/auth/register" class="create-account">
      Create account
    </NuxtLink> -->
    <!-- <div class="recover-password">Recover password</div> -->

    <div class="flex justify-center mt-8 mb-1">
      <hr class="w-24" />
    </div>
    <p>You already have an account ?</p>
    <NuxtLink to="/auth/login" class="text-[#ffbf00] mt-1"> Log in </NuxtLink>
  </form>
</template>

<style scoped>
.login-form {
  display: flex;
  padding: 1.7rem 4rem;
  flex-direction: column;
  align-items: center;
}

label {
  display: flex;
  justify-content: center;
  font-size: 14px;
  margin-bottom: 0.3rem;
  width: 100%;
  text-align: left;
  color: #555;
}

input {
  width: 100%;
  padding: 12px;
  margin-bottom: 1rem;
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
  margin-bottom: 1rem;
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
  margin-top: 0.5rem;
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
