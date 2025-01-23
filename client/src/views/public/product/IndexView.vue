<script setup>
import { onMounted } from "vue";
import { useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { useProductStore } from "@/stores/product";
import { parseRoute } from "@/common/utils/routes";
import ROUTES from "@/common/constants/routes";
import { parseCurrency } from "@/common/utils/currency";

const router = useRouter();
const store = useProductStore();
const { data, isLoading, message, error, errors } = storeToRefs(store);

onMounted(() => {
  store.getAllData();
})
</script>

<template>

<section>
  <div>
    <div class="flex flex-col lg:flex-row w-full  mb-8 gap-4">
      <h1 class="flex-1 text-2xl font-bold">Browse Product</h1>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5 ">
      <template v-if="isLoading">
      </template>

        <template v-else>
            <template v-if="data?.products?.data?.length > 0">
                <div v-for="(item, idx) in data?.products?.data" :key="idx" class="col-span-1">
                    <RouterLink :to="parseRoute(ROUTES.product.show, [item.id])">
                        <div class="card card-compact bg-base-100 shadow-xl w-full rounded">
                            <figure class="h-40">
                                <img
                                :src="item.image"
                                :alt="item.name"
                                class="h-full w-full object-cover" />
                            </figure>

                            <div class="card-body">
                                <h2 class="card-title text-sm line-clamp-2">{{ item.name }}</h2>
                                <h2 class="card-title text-sm line-clamp-2 font-bold">{{ parseCurrency(item.price) }}</h2>
                            </div>
                            </div>
                    </RouterLink>
                </div>
            </template>
        </template>
    </div>
</div>
</section>



</template>

<style scoped></style>