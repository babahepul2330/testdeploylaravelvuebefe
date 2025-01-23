<script setup>
import { RouterLink } from "vue-router";

const props = defineProps(["items"]);
</script>

<template>
  <div class="breadcrumbs text-sm">
    <ul>
      <li v-for="(item, idx) in props.items" :key="idx">
        <div v-if="!item.current" class="badge badge-outline">
          <RouterLink :to="item.route">
            {{ item.title }}
          </RouterLink>
        </div>

        <div v-else class="badge badge-neutral">
          {{ item.title }}
        </div>
      </li>
    </ul>
  </div>
</template>

<style scoped></style>
