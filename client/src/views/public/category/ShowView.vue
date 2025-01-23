<script setup>
import { onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { useCategoryStore } from "@/stores/category";
import { parseRoute } from "@/common/utils/routes";
import ROUTES from "@/common/constants/routes";

const route = useRoute();
const store = useCategoryStore();
const { data, isLoading, message, error, errors } = storeToRefs(store);

onMounted(() => {
  store.getData(route.params.id);
})
</script>

<template>
  <div>
    <div v-if="isLoading" class="flex items-center justify-center h-screen">
      <span class="loading loading-spinner text-neutral"></span>
    </div>
    <div v-else>
      <div class="flex flex-col lg:flex-row w-full mb-8 gap-4">
        <h1 class="flex-1 text-2xl font-bold">
          Showing product by category "{{ data?.category?.name }}"
        </h1>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <template v-if="data?.category?.products?.length > 0">
          <div v-for="(item, idx) in data?.category?.products" :key="idx" class="col-span-1">
            <RouterLink :to="parseRoute(ROUTES.product.show, [item.id])">
              <div class="group card card-compact box-frame bg-base-100 w-full rounded-lg">
                <figure class="h-40">
                  <img :src="item.image" :alt="item.name" class="h-full w-full object-cover" />
                </figure>
                <div class="card-body">
                  <h2 class="card-title text-sm line-clamp-2">{{ item.name }}</h2>
                  <p class="text-sm">{{ (item.price) }}</p>
                </div>
              </div>
            </RouterLink>
          </div>
        </template>
        <template v-else>
          <div class="col-span-full text-center py-10">
            <h2 class="text-2xl font-semibold">No products found in this category</h2>
            <RouterLink to="/category" class="btn btn-primary mt-4">Explore Categories</RouterLink>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<style scoped></style>