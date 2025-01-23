<script setup>
import { onMounted } from "vue";
import { useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { useCategoryStore } from "@/stores/category";
import { parseRoute } from "@/common/utils/routes";
import ROUTES from "@/common/constants/routes";

const router = useRouter();
const store = useCategoryStore();
const { data, isLoading, message, error, errors } = storeToRefs(store);

onMounted(() => {
  store.getAllData({ limit: 1000 });
})
</script>

<template>
  <div>
    <div v-if="isLoading" class="flex items-center justify-center h-screen">
      <span class="loading loading-spinner text-neutral"></span>
    </div>
    <div v-else>
      <div class="flex flex-col lg:flex-row w-full mb-8 gap-4">
        <h1 class="flex-1 text-2xl font-bold">Browse Category</h1>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <template v-if="data?.categories?.data?.length > 0">
          <div v-for="(item, idx) in data?.categories?.data" :key="idx" class="col-span-1">
            <RouterLink :to="parseRoute(ROUTES.category.show, [item.id])">
              <div
                class="group card bg-base-100 w-full h-full box-frame rounded-lg transition-all duration-300 hover:bg-base-200 hover:shadow-lg">
                <div class="card-body flex items-center justify-center transition-all duration-300">
                  <h2
                    class="card-title text-lg group-hover:text-xl group-hover:text-primary transition-all duration-300 text-center">
                    {{ item.name }}
                  </h2>
                </div>
              </div>
            </RouterLink>
          </div>
        </template>
        <template v-else>
          <div class="col-span-full text-center py-10">
            <h2 class="text-2xl font-semibold">No categories found</h2>
            <RouterLink to="/" class="btn btn-primary mt-4">Back to Home</RouterLink>
          </div>
        </template>
      </div>
    </div>
  </div>
</template>

<style scoped></style>