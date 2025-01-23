import { ref } from "vue";
import { defineStore } from "pinia";
import fetcher from "@/config/axios";

export const useCategoryStore = defineStore("category", () => {
  const isLoading = ref(false);
  const message = ref("");
  const error = ref(false);
  const errors = ref(null);

  const data = ref(null);

  function resetData() {
    data.value = null;
  }

  function resetState() {
    isLoading.value = false;
    message.value = "";
    error.value = false;
    errors.value = null;
  }

  async function getAllData(params = {}) {
    try {
      resetState();
      isLoading.value = true;

      const { data: res } = await fetcher.get("/category", { params });
      data.value = res.data;
    } catch ({ response }) {
      error.value = response.data?.error;
      message.value = response.data?.message ?? "Failed";
      errors.value = response.data?.errors;
    } finally {
      isLoading.value = false;
    }
  }

  async function getData(id) {
    try {
      resetState();
      isLoading.value = true;

      const { data: res } = await fetcher.get(`/category/${id}`);
      data.value = res.data;
    } catch ({ response }) {
      error.value = response.data?.error;
      message.value = response.data?.message ?? "Failed";
      errors.value = response.data?.errors;
    } finally {
      isLoading.value = false;
    }
  }

  async function createData(payload) {
    try {
      resetState();
      isLoading.value = true;

      const { data: res } = await fetcher.post(`/category`, payload);
      message.value = res?.message;
    } catch ({ response }) {
      error.value = response.data?.error;
      message.value = response.data?.message ?? "Failed";
      errors.value = response.data?.errors;
    } finally {
      isLoading.value = false;
    }
  }

  async function editData(id, payload) {
    try {
      resetState();
      isLoading.value = true;

      const { data: res } = await fetcher.post(
        `/category/${id}?_method=PATCH`,
        payload
      );

      message.value = res?.message;
    } catch ({ response }) {
      error.value = response.data?.error;
      message.value = response.data?.message ?? "Failed";
      errors.value = response.data?.errors;
    } finally {
      isLoading.value = false;
    }
  }

  async function deleteData(id) {
    try {
      resetState();
      isLoading.value = true;

      const { data: res } = await fetcher.post(
        `/category/${id}?_method=DELETE`
      );
      message.value = res?.message;
    } catch ({ response }) {
      error.value = response.data?.error;
      message.value = response.data?.message ?? "Failed";
      errors.value = response.data?.errors;
    } finally {
      isLoading.value = false;
    }
  }

  return {
    data,
    isLoading,
    message,
    error,
    errors,
    resetData,
    resetState,
    getAllData,
    getData,
    createData,
    editData,
    deleteData,
  };
});
