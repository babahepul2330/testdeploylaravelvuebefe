<script setup>
import Navbar from "./partials/Navbar.vue";
import Sidebar from "./partials/Sidebar.vue";
</script>

<template>
  <div class="drawer drawer-end">
    <input id="drawerLayout" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content">
      <Navbar />

      <main class="container mx-auto p-2 min-h-[75svh] my-10">
        <slot name="main"></slot>
      </main>

      <!-- footer -->
      <!-- <footer></footer> -->
    </div>
    <div class="drawer-side z-10">
      <label
        for="drawerLayout"
        aria-label="close sidebar"
        class="drawer-overlay"
      ></label>

      <Sidebar />
    </div>
  </div>
</template>

<style scoped></style>
