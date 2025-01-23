<script setup>
import { RouterLink } from "vue-router";
import { Bars3Icon } from "@heroicons/vue/24/solid";
</script>

<template>
  <nav class="bg-base-100 border-b-2 border-neutral sticky top-0 z-10">
    <div class="navbar container mx-auto">
      <div class="flex-none">
        <label
          for="drawerLayout"
          class="btn btn-square btn-ghost inline-flex lg:hidden"
        >
          <Bars3Icon class="size-6" />
        </label>
      </div>
      <div class="flex-1">
        <RouterLink
          to="/"
          class="btn btn-ghost text-xl font-extrabold lg:hidden"
        >
          E-Commerce
        </RouterLink>
      </div>
    </div>
  </nav>
</template>

<style scoped></style>
