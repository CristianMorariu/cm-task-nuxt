import axios from "axios";
// import { useAuthStore } from "./stores/authStore";
// import { useInstitutionStore } from "./stores/institutionStore";
// import router from "./router";

axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL;
axios.defaults.withCredentials = true;

axios.interceptors.request.use(
  function (config) {
    // Do something before request is sent
    return config;
  },
  function (error) {
    return Promise.reject(error);
  }
);

axios.interceptors.response.use(
  function (response) {
    // Do something with response data
    return response;
  },
  function (error) {
    return Promise.reject(error);
  }
);
export default axios;
