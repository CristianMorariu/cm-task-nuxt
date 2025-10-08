<script setup lang="ts">
definePageMeta({
  layout: "auth-layout",
  authTitle: "Login",
});

const auth = useAuth();
const form: {
  username: string;
  password: string;
} = reactive({
  username: "admin@gmail.com",
  password: "Password",
});

const errors: any = ref({});

async function handleSubmit() {
  console.log(form);
  try {
    const { $api } = useNuxtApp();
    const resp = await $api.post("/login", form);
    await auth.login(resp);
  } catch (error: any) {
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
  <form @submit.prevent="handleSubmit" class="login-form">
    <label for="username">Enter Email or Username </label>
    <input
      v-model="form.username"
      type="username"
      id="username"
      placeholder="Email"
    />
    <div v-if="errors.username" style="color: orangered">
      {{ errors?.username[0] }}
    </div>
    <label for="password">Enter Password</label>
    <input
      v-model="form.password"
      type="password"
      id="password"
      placeholder="Password"
      autocomplete="off"
    />
    <div v-if="errors.message" style="color: orangered">
      {{ errors?.message }}
    </div>
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
    <!-- <div class="recover-password">Recover password</div> -->
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
  margin-bottom: 5px;
  width: 100%;
  text-align: left;
  color: #555;
}

input[type="username"],
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

input[type="username"]:focus,
input[type="password"]:focus {
  border-color: #ffbf00;
}

/* Checkbox-ul și label-ul */
.remember-me {
  display: flex;
  align-items: center;
  justify-content: center;
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
