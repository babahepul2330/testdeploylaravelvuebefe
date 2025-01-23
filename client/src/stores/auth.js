import { computed, ref } from "vue";
import { defineStore } from "pinia";
import fetcher from "@/config/axios";

export const useAuthStore = defineStore("auth", () => {
  const initialized = ref(false);
  const isLoading = ref(false);
  const message = ref("");
  const error = ref(false);
  const errors = ref(null);

  const isAdmin = ref(false);
  const user = ref(null);
  const isVerified = computed(() => !!user.value?.email_verified_at);

  function resetData() {
    user.value = null;
    isAdmin.value = false;
    isVerified.value = false;
  }

  function resetState() {
    isLoading.value = false;
    message.value = "";
    error.value = false;
    errors.value = null;
  }

  async function initialize() {
    const token = localStorage.getItem("token");

    if (token) {
      await profile();
    }
  }

  async function profile() {
    try {
      resetState();
      isLoading.value = true;

      const { data: res } = await fetcher.get("/me");
      user.value = res?.data?.user;
      isAdmin.value = res?.data?.user?.role?.name === "admin";
    } catch ({ response }) {
      error.value = true;
      message.value = response.data?.message ?? "Failed";
      if (response.status === 400) errors.value = response.data?.errors;
    } finally {
      isLoading.value = false;
    }
  }

  async function updateProfile(payload) {
    try {
      resetState();
      isLoading.value = true;

      const { data: res } = await fetcher.postForm("/profile", payload);
      profile.value = res?.data?.profile;
      message.value = res?.message;
    } catch ({ response }) {
      error.value = true;
      message.value = response.data?.message ?? "Failed";
      if (response.status === 400) errors.value = response.data?.errors;
    } finally {
      isLoading.value = false;
    }
  }

  async function login(payload) {
    try {
      resetState();
      isLoading.value = true;

      const { data: res } = await fetcher.post("/auth/login", payload);
      user.value = res?.data?.user;
      isAdmin.value = res?.data?.user?.role?.name === "admin";
      message.value = res?.message;
      localStorage.setItem("token", res?.data?.token);
    } catch ({ response }) {
      error.value = true;
      message.value = response.data?.message ?? "Failed";
      if (response.status === 400) errors.value = response.data?.errors;
    } finally {
      isLoading.value = false;
    }
  }

  async function register(payload) {
    try {
      resetState();
      isLoading.value = true;

      const { data: res } = await fetcher.post("/auth/register", payload);
      message.value = res?.message;
    } catch ({ response }) {
      error.value = true;
      message.value = response.data?.message ?? "Failed";
      if (response.status === 400) errors.value = response.data?.errors;
    } finally {
      isLoading.value = false;
    }
  }

  async function logout() {
    try {
      resetState();
      isLoading.value = true;

      const { data: res } = await fetcher.post("/auth/logout");
      message.value = res?.message;
      localStorage.removeItem("token");
    } catch ({ response }) {
      error.value = true;
      message.value = response.data?.message ?? "Failed";
      if (response.status === 400) errors.value = response.data?.errors;
    } finally {
      isLoading.value = false;
    }
  }

  async function generateToken() {
    try {
      resetState();
      isLoading.value = true;

      const { data: res } = await fetcher.post("/auth/generate-otp-code", {
        email: user.value?.email,
      });

      message.value = res?.message;
    } catch ({ response }) {
      error.value = true;
      message.value = response.data?.message ?? "Failed";
      if (response.status === 400) errors.value = response.data?.errors;
    } finally {
      isLoading.value = false;
    }
  }

  async function verifyAccount(payload) {
    try {
      resetState();
      isLoading.value = true;

      const { data: res } = await fetcher.post(
        "/auth/verifikasi-akun",
        payload
      );

      user.value = res?.data?.user
      message.value = res?.message;
    } catch ({ response }) {
      error.value = true;
      message.value = response.data?.message ?? "Failed";
      if (response.status === 400) errors.value = response.data?.errors;
    } finally {
      isLoading.value = false;
    }
  }

  return {
    user,
    isAdmin,
    isVerified,
    initialized,
    isLoading,
    message,
    error,
    errors,
    resetData,
    resetState,
    initialize,
    login,
    register,
    logout,
    profile,
    updateProfile,
    generateToken,
    verifyAccount,
  };
});
