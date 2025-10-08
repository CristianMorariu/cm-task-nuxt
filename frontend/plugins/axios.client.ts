import axios from "axios";
import type { AxiosInstance } from "axios";

export default defineNuxtPlugin(() => {
  const api: AxiosInstance = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL,
    withCredentials: false, // Bearer only
  });

  api.interceptors.request.use((config) => {
    const token = useToken().value;
    if (token) config.headers.Authorization = `Bearer ${token}`;
    return config;
  });

  return {
    provide: { api }, // folosit cu const { $api } = useNuxtApp()
  };
});
