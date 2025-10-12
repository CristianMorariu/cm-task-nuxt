import axios from "axios";
import type { AxiosInstance } from "axios";

export default defineNuxtPlugin(() => {
  const api: AxiosInstance = axios.create({
    baseURL: import.meta.env.VITE_API_BASE_URL,
    withCredentials: true,
    xsrfCookieName: "XSRF-TOKEN",
    xsrfHeaderName: "X-XSRF-TOKEN",
  });

  api.interceptors.request.use((config) => {
    if (import.meta.client) {
      const match = document.cookie.match(/XSRF-TOKEN=([^;]+)/);
      if (match) {
        config.headers["X-XSRF-TOKEN"] = decodeURIComponent(match[1]);
      }
    }
    return config;
  });

  return {
    provide: { api }, // folosit cu const { $api } = useNuxtApp()
  };
});
