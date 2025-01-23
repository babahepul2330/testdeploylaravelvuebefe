<script setup>
import { RouterLink } from "vue-router";
import { Bars3Icon } from "@heroicons/vue/24/solid";
import NavbarMenu from "./NavbarMenu.vue";
</script>

<template>
  <nav class="bg-base-100 border-b-2 border-neutral sticky top-0 z-10">
    <div class="navbar container mx-auto">
      <div class="flex-1">
        <RouterLink to="/" class="btn btn-ghost text-xl font-extrabold">
          E-Commerce
        </RouterLink>
      </div>
      <div class="flex flex-row gap-12 flex-none">
        <template class="hidden md:block">
          <NavbarMenu />
        </template>

        <label
          for="drawerLayout"
          class="btn btn-square btn-ghost inline-flex md:hidden"
        >
          <Bars3Icon class="size-6" />
        </label>
      </div>
    </div>
  </nav>
</template>

<style scoped></style>
