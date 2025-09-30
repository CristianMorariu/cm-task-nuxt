import axios from "axios";

axios.defaults.baseURL = import.meta.env.VITE_API_BASE_URL;
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

console.log(axios.defaults.baseURL);

axios.interceptors.request.use(
  function (config) {
    // Do something before request is sent
    // config.headers.Authorization = `Bearer ${localStorage.getItem("token")}`;
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
