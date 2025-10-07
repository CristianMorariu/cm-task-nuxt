import axios from "axios";

axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL;
// axios.defaults.withCredentials = true;
// axios.defaults.withXSRFToken = true;

// console.log(axios.defaults.baseURL);

axios.interceptors.request.use(
  function (config) {
    const token = localStorage.getItem("access_token");
    if (token) config.headers.Authorization = `Bearer ${token}`;
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
    if (error.response && error.response.status === 401) {
      // router.push({name:'Login'});
    }
    // return Promise.reject(error);
    throw error;
  }
);
export default axios;
