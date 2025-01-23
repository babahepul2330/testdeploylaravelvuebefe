<script setup>
import { computed } from "vue";
import { RouterView, useRoute } from "vue-router";
import { Toaster } from "@steveyuowo/vue-hot-toast";
import AppLayout from "@/components/layout/AppLayout.vue";
import AdminLayout from "@/components/layout/AdminLayout.vue";

const route = useRoute();

const getCurrentLayout = computed(() => {
  return route.meta.layout === "AdminLayout" ? AdminLayout : AppLayout;
});
</script>

<template>
  <component :is="getCurrentLayout">
    <template #main>
      <Toaster />
      <RouterView />
    </template>
  </component>
</template>

<style scoped></style>
