import { reactive, ref } from "vue";
import { defineStore } from "pinia";
import fetcher from "@/config/axios";

export const useOrderStore = defineStore("order", () => {
  const cart = reactive({
    product: null,
    quantity: null,
  });

  const isLoading = ref(false);
  const message = ref("");
  const error = ref(false);
  const errors = ref(null);

  const data = ref(null);

  function resetData() {
    data.value = null;
    cart.product = null;
    cart.quantity = null;
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

      const { data: res } = await fetcher.get("/order", { params });
      data.value = res.data;
    } catch ({ response }) {
      error.value = response.data?.error;
      message.value = response.data?.message ?? "Failed";
      errors.value = response.data?.errors;
    } finally {
      isLoading.value = false;
    }
  }

  async function getMyData() {
    try {
      resetState();
      isLoading.value = true;

      const { data: res } = await fetcher.get("/order/my");
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

      const { data: res } = await fetcher.get(`/order/${id}`);
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

      const { data: res } = await fetcher.post(`/order`, payload);
      message.value = res?.message;
      data.value = res?.data;
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
        `/order/${id}?_method=PATCH`,
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

      const { data: res } = await fetcher.post(`/order/${id}?_method=DELETE`);
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
    cart,
    isLoading,
    message,
    error,
    errors,
    resetData,
    resetState,
    getAllData,
    getMyData,
    getData,
    createData,
    editData,
    deleteData,
  };
});
