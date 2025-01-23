<script setup>
import { onMounted } from "vue";
import { useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { useCategoryStore } from "@/stores/category";
import { useProductStore } from "@/stores/product";
import { parseRoute } from "@/common/utils/routes";
import ROUTES from "@/common/constants/routes";
import { parseCurrency } from "@/common/utils/currency";

const router = useRouter();
const categoryStore = useCategoryStore();
const productStore = useProductStore();

const {
  data: categoryData,
  isLoading: categoryLoading,
  message: categoryMessage,
  error: categoryError,
  errors: categoryErrors,
} = storeToRefs(categoryStore);

const {
  data: productData,
  isLoading: productLoading,
  message: productMessage,
  error: productError,
  errors: productErrors,
} = storeToRefs(productStore);

onMounted(() => {
  categoryStore.getAllData({ limit: 8 });
  productStore.getAllData({ limit: 30 });
});
</script>

<template>
  <section>
    <!-- Hero Section -->
    <div class="hero bg-black text-white py-6 md:py-10">
      <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold text-center mb-4">Welcome to Our Store</h1>
        <p class="text-center text-base md:text-lg mb-6">Browse popular categories and explore our top products</p>
      </div>
    </div>

    <!-- Popular Categories -->
    <div class="container mx-auto pt-10">
      <div class="flex flex-row justify-between items-center gap-5 mb-8">
        <h2 class="text-2xl font-bold mb-1">Popular Categories</h2>
        <RouterLink to="/category" class="btn btn-primary mb-1">Browse Categories</RouterLink>
      </div>
      <div v-if="categoryLoading" class="flex items-center justify-center h-40">
        <span class="loading loading-spinner text-neutral"></span>
      </div>
      <div v-else>
        <template v-if="categoryData?.categories?.data?.length > 0">
          <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            <div v-for="(item, idx) in categoryData?.categories?.data" :key="idx" class="col-span-1">
              <RouterLink :to="parseRoute(ROUTES.category.show, [item.id])">
                <div
                  class="group card bg-base-100 w-full h-full rounded transition-all duration-300 hover:bg-base-200 hover:shadow-lg">
                  <div class="card-body flex items-center justify-center p-4 transition-all duration-300">
                    <h2
                      class="card-title text-lg group-hover:text-xl group-hover:text-primary transition-all duration-300 text-center">
                      {{ item.name }}
                    </h2>
                  </div>
                </div>
              </RouterLink>
            </div>
          </div>
        </template>
        <template v-else>
          <div class="text-center py-10">
            <h2 class="text-2xl font-semibold">No popular categories found</h2>
          </div>
        </template>
      </div>
    </div>

    <!-- Popular Products -->
    <div class="container mx-auto pt-10">
      <div class="flex flex-row justify-between items-center gap-5 mb-8">
        <h2 class="text-2xl font-bold mb-1">Popular Products</h2>
        <RouterLink to="/product" class="btn btn-primary mb-1">Browse Products</RouterLink>
      </div>
      <div v-if="productLoading" class="flex items-center justify-center h-40">
        <span class="loading loading-spinner text-neutral"></span>
      </div>
      <div v-else>
        <template v-if="productData?.products?.data?.length > 0">
          <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3 ">
            <div v-for="(item, idx) in productData?.products?.data" :key="idx" class="col-span-1">
              <RouterLink :to="parseRoute(ROUTES.product.show, [item.id])">
                <div class="card card-compact bg-base-100 shadow-xl w-full rounded">
                  <figure class="h-40">
                    <img :src="item.image" :alt="item.name" class="h-full w-full object-cover" laz />
                  </figure>
                  <div class="card-body">
                    <h2 class="card-title text-sm line-clamp-2">{{ item.name }}</h2>
                    <h2 class="card-title text-sm line-clamp-2 font-bold">{{ parseCurrency(item.price) }}</h2>
                  </div>
                </div>
              </RouterLink>
            </div>
          </div>
        </template>
        <template v-else>
          <div class="text-center py-10">
            <h2 class="text-2xl font-semibold">No popular products found</h2>
          </div>
        </template>
      </div>
    </div>
  </section>
</template>

<style scoped></style>
