<script setup>
import { onMounted } from "vue";
import { RouterLink } from "vue-router";
import { storeToRefs } from "pinia";
import { EyeIcon } from "@heroicons/vue/24/solid";
import { useOrderStore } from "@/stores/order";
import { parseRoute } from "@/common/utils/routes";
import ROUTES from "@/common/constants/routes";
import { parseCurrency } from "@/common/utils/currency";

const store = useOrderStore();
const { data, isLoading } = storeToRefs(store);

onMounted(async () => {
  await store.getMyData();
});
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold mb-8">My Order History</h1>

    <div class="overflow-x-auto">
      <table class="table">
        <thead>
          <tr class="text-center">
            <th></th>
            <th>Product</th>
            <th>Order ID</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Transaction Date</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <template v-if="isLoading">
            <tr>
              <td colspan="8" class="text-center">Loading...</td>
            </tr>
          </template>
          <template v-else>
            <template v-if="data?.orders?.length > 0">
              <tr v-for="(item, idx) in data.orders" :key="idx">
                <th>{{ idx + 1 }}</th>
                <td>
                  <div class="flex items-center gap-5">
                    <div class="avatar">
                      <div class="mask mask-squircle h-12 w-12">
                        <img
                          :src="item?.product?.image"
                          :alt="item?.product?.name ?? 'Product Image'"
                        />
                      </div>
                    </div>
                    <div>
                      <div class="font-bold line-clamp-1">
                        {{ item?.product?.name }}
                      </div>
                      <div class="text-sm opacity-50 line-clamp-1">
                        {{ item?.product?.category?.name }}
                      </div>
                    </div>
                  </div>
                </td>
                <td class="text-center">
                  <span class="font-medium">
                    {{ item?.order_id }}
                  </span>
                </td>
                <td class="text-center">
                  x<span class="font-medium">{{ item?.quantity }}</span>
                </td>
                <td class="text-end">
                  {{ parseCurrency(item?.total_price) }}
                </td>
                <td class="text-center">
                  <span
                    class="badge badge-sm"
                    :class="{
                      'bg-emerald-100': item?.status === 'success',
                      'bg-yellow-100': item?.status === 'pending',
                      'bg-red-100': item?.status === 'cancel',
                      'badge-outline': !item?.status,
                    }"
                  >
                    {{ item?.status ?? "???" }}
                  </span>
                </td>
                <td class="text-center">
                  {{ new Date(item.created_at).toLocaleString() }}
                </td>
                <th>
                  <RouterLink
                    :to="parseRoute(ROUTES.order.show, [item?.id])"
                    class="btn btn-ghost btn-sm bg-blue-100"
                  >
                    <EyeIcon class="size-3" />
                    Detail
                  </RouterLink>
                </th>
              </tr>
            </template>
            <template v-else>
              <tr>
                <td colspan="8" class="text-center">No order history</td>
              </tr>
            </template>
          </template>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped></style>
