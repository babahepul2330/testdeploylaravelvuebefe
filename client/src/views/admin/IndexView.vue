<script setup>
import { onMounted, ref } from "vue";
import { storeToRefs } from "pinia";
import { useAuthStore } from "@/stores/auth";
import BreadCrumb from "@/components/BreadCrumb.vue";
import fetcher from "@/config/axios";
import { parseCurrencyWithUnits } from "@/common/utils/currency";

const authStore = useAuthStore();
const isLoading = ref(false)
const data = ref(null)

const breadcrumbs = ref([
  { title: "Dashboard", current: true },
]);

const {
  data: userData,
  isLoading: userLoading
} = storeToRefs(authStore);

onMounted(async () => {
  await getAllData()
});

async function getAllData() {
  try {
    isLoading.value = true;

    const { data: res } = await fetcher.get("/dashboard");

    data.value = res.data;
  } catch ({ response }) {
    console.error(response?.data?.message ?? "Failed");
  } finally {
    isLoading.value = false;
  }
}
</script>

<template>
  <div>
    <BreadCrumb :items="breadcrumbs" />

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mt-5 mb-8">
      <div class="card shadow w-full">
        <div class="card-body">
          <p class="card-title">Total Revenue</p>
          <h1 class="text-4xl font-bold">{{ parseCurrencyWithUnits(data?.revenue) }}</h1>
        </div>
      </div>

      <div class="card shadow w-full">
        <div class="card-body">
          <p class="card-title">Total Product</p>
          <h1 class="text-4xl font-bold">{{ data?.product }}</h1>
        </div>
      </div>

      <div class="card shadow w-full">
        <div class="card-body">
          <p class="card-title">Total Category</p>
          <h1 class="text-4xl font-bold">{{ data?.category }}</h1>
        </div>
      </div>

      <div class="card shadow w-full">
        <div class="card-body">
          <p class="card-title">Total Purchase</p>
          <h1 class="text-4xl font-bold">{{ data?.order }}</h1>
        </div>
      </div>

      <div class="card shadow w-full">
        <div class="card-body">
          <p class="card-title">Purchase Success</p>
          <h1 class="text-4xl font-bold">{{ data?.orderSuccess }}</h1>
        </div>
      </div>

      <div class="card shadow w-full">
        <div class="card-body">
          <p class="card-title">Pending Purchase</p>
          <h1 class="text-4xl font-bold">{{ data?.orderPending }}</h1>
        </div>
      </div>

      <div class="card shadow w-full">
        <div class="card-body">
          <p class="card-title">Purchase Canceled</p>
          <h1 class="text-4xl font-bold">{{ data?.orderCancel }}</h1>
        </div>
      </div>

      <div class="card shadow w-full">
        <div class="card-body">
          <p class="card-title">User Registered</p>
          <h1 class="text-4xl font-bold">{{ data?.user }}</h1>
        </div>
      </div>
    </div>
  </div>

</template>

<style scoped></style>
