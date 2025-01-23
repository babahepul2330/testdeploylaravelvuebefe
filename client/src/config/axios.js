import axios from "axios";
import ROUTES from "@/common/constants/routes";

const fetcher = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  headers: {
    Accept: "application/json",
    Authorization: `Bearer ${localStorage.getItem("token")}`,
  },
});

fetcher.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("token");

    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }

    return config;
  },
  ({ response }) => {
    return response;
  }
);

fetcher.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    if (error.response) {
      const statusCode = error.response.status;
      const errorMessage = error.response.data.message || "An error occurred";

      if (statusCode === 401) {
        localStorage.removeItem("token");
        window.location.href = ROUTES.login;
        console.error("Unauthorized access - redirecting to login");
      } else if (statusCode === 500) {
        console.error("Server error - try again later");
      } else {
        console.error(`Error ${statusCode}: ${errorMessage}`);
      }
    } else if (error.request) {
      console.error("Network error - check your internet connection");
    } else {
      console.error("Request error:", error.message);
    }

    return Promise.reject(error);
  }
);

export default fetcher;
