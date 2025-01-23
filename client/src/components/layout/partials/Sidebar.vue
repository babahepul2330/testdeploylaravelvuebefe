<script setup>
import { XMarkIcon } from "@heroicons/vue/24/solid";
import NavbarMenu from "./NavbarMenu.vue";
</script>

<template>
  <ul class="menu bg-base-100 text-base-content min-h-full w-80 p-0">
    <div class="bg-base-100 border-b-2 border-neutral">
      <div class="navbar container mx-auto">
        <div class="flex-1"></div>
        <div class="flex-none">
          <label
            for="drawerLayout"
            class="btn btn-square btn-ghost inline-flex md:hidden"
          >
            <XMarkIcon class="size-6" />
          </label>
        </div>
      </div>
    </div>

    <div class="p-4">
      <NavbarMenu />
    </div>
  </ul>
</template>

<style scoped></style>
