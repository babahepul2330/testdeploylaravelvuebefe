<script setup>
import NavbarAdmin from "./partials/NavbarAdmin.vue";
import SidebarAdmin from "./partials/SidebarAdmin.vue";
</script>

<template>
  <div class="drawer drawer-start lg:drawer-open">
    <input id="drawerLayout" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content">
      <NavbarAdmin />

      <main class="container mx-auto p-3 lg:px-8 min-h-[80svh]">
        <slot name="main"></slot>
      </main>

      <!-- footer -->
      <!-- <footer></footer> -->
    </div>
    <div class="drawer-side border-e-2 border-neutral z-10">
      <label
        for="drawerLayout"
        aria-label="close sidebar"
        class="drawer-overlay"
      ></label>

      <SidebarAdmin />
    </div>
  </div>
</template>

<style scoped></style>
