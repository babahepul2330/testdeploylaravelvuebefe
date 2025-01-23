<script setup>
import { RouterLink } from "vue-router";
import { XMarkIcon } from "@heroicons/vue/24/solid";
import NavbarMenuAdmin from "./NavbarMenuAdmin.vue";
</script>

<template>
  <ul class="menu bg-base-100 text-base-content min-h-full w-80 p-0">
    <div class="bg-base-100 border-b-2 border-neutral">
      <div class="navbar container mx-auto">
        <div class="flex-none">
          <label
            for="drawerLayout"
            class="btn btn-square btn-ghost inline-flex lg:hidden"
          >
            <XMarkIcon class="size-6" />
          </label>
        </div>
        <div class="flex-1">
          <RouterLink to="/" class="btn btn-ghost text-xl font-extrabold">
            E-Commerce
          </RouterLink>
        </div>
      </div>
    </div>

    <div class="p-4">
      <NavbarMenuAdmin />
    </div>
  </ul>
</template>

<style scoped></style>
