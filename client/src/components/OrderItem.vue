<script setup>
import { parseCurrency } from "@/common/utils/currency";
import { computed } from "vue";

const props = defineProps({
  item: {
    required: true,
    type: Object,
  },
});

const item = computed(() => props.item);
</script>

<template>
  <div
    class="card card-compact card-side items-start p-1 border border-neutral/50"
  >
    <figure class="size-20">
      <img :src="item?.image" :alt="item?.name" class="h-full w-full" />
    </figure>
    <div class="card-body">
      <h3 class="card-title text-base font-semibold line-clamp-1">
        {{ item?.name }}
      </h3>

      <p class="inline-flex justify-between">
        <span>{{ parseCurrency(item?.price) }}</span>
        <span>x{{ item?.quantity }}</span>
      </p>

      <p class="text-end font-medium">
        Total {{ item?.quantity }} product:
        {{ parseCurrency(item?.total_price) }}
      </p>
    </div>
  </div>
</template>

<style scoped></style>
