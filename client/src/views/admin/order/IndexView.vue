<script setup>
import { computed, reactive, ref, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { MagnifyingGlassIcon } from "@heroicons/vue/24/solid";
import { useOrderStore } from "@/stores/order";
import BreadCrumb from "@/components/BreadCrumb.vue";
import TableRender from "@/components/TableRender.vue";
import ROUTES from "@/common/constants/routes";

const route = useRoute();
const router = useRouter();
const store = useOrderStore();
const params = computed(() => route.query);
const { data, isLoading, message, error, errors } = storeToRefs(store);

const rows = computed(() => [
  { title: "Order ID", data: "order_id", class: "text-center font-medium" },
  { title: "Customer Name", data: "first_name" },
  { title: "Quantity", data: "quantity", class: "text-center" },
  { title: "Total Price", data: "total_price", class: "text-end" },
  { title: "Status", data: "status", class: "text-center" },
  {
    title: "Action",
    routeShow: { route: ROUTES.admin.order.show, params: ["id"] },
  },
]);

const breadcrumbs = ref([
  { title: "Dashboard", route: ROUTES.admin.index },
  { title: "Order", route: ROUTES.admin.order.index, current: true },
]);

const form = reactive({
  search: params?.value?.search ?? ""
})

watch(
  params,
  (newQs, oldQs) => {
    store.getAllData({ ...params.value });
  },
  { immediate: true }
);

function handleSearch() {
  router.push({
    path: ROUTES.admin.order.index,
    query: form
  })
}
</script>

<template>
  <div>
    <BreadCrumb :items="breadcrumbs" />

    <div class="flex flex-col lg:flex-row w-full mt-5 mb-8 gap-4">
      <h1 class="flex-1 text-2xl font-bold">List Order</h1>

      <div class="inline-flex items-center justify-between gap-5">
        <form class="join" @submit.prevent="handleSearch">
          <input v-model="form.search" class="input input-bordered input-sm w-36 sm:w-44 join-item" />
          <button type="submit" class="btn btn-frame-outline btn-sm join-item">
            <MagnifyingGlassIcon class="size-4" />
            <span class="hidden sm:inline">Search</span>
          </button>
        </form>
      </div>
    </div>

    <TableRender :pagination="data?.orders" :rows="rows" :isLoading="isLoading" />
  </div>
</template>

<style scoped></style>
