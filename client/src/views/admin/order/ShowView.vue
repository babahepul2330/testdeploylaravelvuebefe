<script setup>
import { onBeforeMount, onMounted, ref } from "vue";
import { RouterLink, useRoute } from "vue-router";
import { storeToRefs } from "pinia";
import { ChevronLeftIcon } from "@heroicons/vue/24/solid";
import { useOrderStore } from "@/stores/order";
import { parseCurrency } from "@/common/utils/currency";
import BreadCrumb from "@/components/BreadCrumb.vue";
import ROUTES from "@/common/constants/routes";

const route = useRoute();
const orderStore = useOrderStore();
const { data, isLoading } = storeToRefs(orderStore);

const breadcrumbs = ref([
  { title: "Dashboard", route: ROUTES.admin.index },
  { title: "Order", route: ROUTES.admin.order.index },
  { title: "Detail", current: true },
]);

onBeforeMount(() => {
  orderStore.getData(route.params?.id);
});

onMounted(() => {
  orderStore.resetState();
});
</script>

<template>
  <div>
    <BreadCrumb :items="breadcrumbs" />

    <div class="inline-flex w-full mt-5 mb-8">
      <h1 class="flex-1 text-2xl font-bold">Detail Order</h1>

      <RouterLink
        :to="ROUTES.admin.order.index"
        class="flex-none btn btn-frame-outline btn-success btn-sm"
      >
        <ChevronLeftIcon class="size-4" />
        <span>Back</span>
      </RouterLink>
    </div>

    <div class="w-full max-w-2xl mx-auto box-frame">
      <div class="card-body">
        <div>
          <h2 class="text-xl font-medium mb-5">Shipping Information</h2>

          <div class="grid grid-cols-2 gap-5">
            <div class="col-span-1">
              <p class="text-base mb-3">First Name</p>
              <p class="p-3 bg-neutral-200/70">{{ data?.order?.first_name }}</p>
            </div>
            <div class="col-span-1">
              <p class="text-base mb-3">Last Name</p>
              <p class="p-3 bg-neutral-200/70">{{ data?.order?.last_name }}</p>
            </div>
            <div class="col-span-2">
              <p class="text-base mb-3">Address</p>
              <p class="p-3 bg-neutral-200/70 min-h-28">
                {{ data?.order?.address }}
              </p>
            </div>
          </div>
        </div>

        <div class="divider divider-neutral"></div>

        <div>
          <h2 class="text-xl font-medium mb-5">Item List</h2>

          <div
            class="card card-compact card-side items-start p-1 border border-neutral/50"
          >
            <figure class="size-24">
              <img
                :src="data?.order?.product?.image"
                :alt="data?.order?.product?.name"
                class="h-full w-full"
              />
            </figure>
            <div class="card-body">
              <h3 class="card-title text-lg font-semibold line-clamp-3">
                {{ data?.order?.product?.name }}
              </h3>
            </div>
          </div>
        </div>

        <div class="divider divider-neutral"></div>

        <div>
          <h2 class="text-xl font-medium mb-5">Transaction Details</h2>

          <div class="overflow-x-auto">
            <table class="table">
              <tbody class="text-base">
                <tr>
                  <td>Order Date</td>
                  <td class="text-end">
                    {{ new Date(data?.order?.created_at).toLocaleDateString() }}
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td>Order Time</td>
                  <td class="text-end">
                    {{ new Date(data?.order?.created_at).toLocaleTimeString() }}
                  </td>
                  <td></td>
                </tr>
                <tr>
                  <td>Status</td>
                  <td class="text-end">
                    <span
                      class="badge"
                      :class="{
                        'bg-emerald-100': data?.order?.status === 'success',
                        'bg-yellow-100': data?.order?.status === 'pending',
                        'bg-red-100': data?.order?.status === 'cancel',
                        'badge-outline': !data?.order?.status,
                      }"
                    >
                      {{ data?.order?.status ?? "???" }}
                    </span>
                  </td>
                  <td></td>
                </tr>
                <tr class="border-1 border-neutral">
                  <td>Price</td>
                  <td class="text-end">
                    x<span class="font-medium">{{
                      data?.order?.quantity
                    }}</span>
                  </td>
                  <td class="text-end">
                    {{ parseCurrency(data?.order?.price) }}
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="text-end font-medium">Total</td>
                  <td class="text-end">
                    {{ parseCurrency(data?.order?.total_price) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
