<script setup>
import { useRouter } from "vue-router";
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/24/solid";

const props = defineProps(["links", "currentPage"]);
const router = useRouter();

function handleClick(link) {
  const url = new URL(link);
  const params = new URLSearchParams(url.search);
  const query = Object.fromEntries(params.entries());

  router.push({ query });
  active.value = query.page;
}
</script>

<template setup>
  <div class="join hidden md:inline-flex">
    <template v-for="(item, idx) in props?.links" :key="idx">
      <button
        v-if="idx === 0"
        class="join-item btn btn-sm"
        :class="{
          'btn-frame-outline': item.label != props.currentPage,
          'btn-frame': item.label == props.currentPage,
        }"
        :disabled="!item.url"
        @click.prevent="() => handleClick(item.url)"
      >
        <ChevronLeftIcon class="size-5" />
      </button>

      <button
        v-else-if="idx === props?.links?.length - 1"
        class="join-item btn btn-sm"
        :class="{
          'btn-frame-outline': item.label != props.currentPage,
          'btn-frame': item.label == props.currentPage,
        }"
        :disabled="!item.url"
        @click.prevent="() => handleClick(item.url)"
      >
        <ChevronRightIcon class="size-5" />
      </button>

      <button
        v-else
        class="join-item btn btn-sm"
        :class="{
          'btn-frame-outline': item.label != props.currentPage,
          'btn-frame': item.label == props.currentPage,
        }"
        :disabled="!item.url"
        @click.prevent="() => handleClick(item.url)"
      >
        {{ item.label }}
      </button>
    </template>
  </div>

  <div class="join md:hidden">
    <button
      class="join-item btn btn-sm btn-frame-outline"
      :disabled="!props?.links[0].url"
      @click.prevent="() => handleClick(props?.links[0].url)"
    >
      <ChevronLeftIcon class="size-5" />
      Prev
    </button>

    <button class="join-item btn btn-sm btn-frame-outline">
      {{ props.currentPage }}
    </button>

    <button
      class="join-item btn btn-sm btn-frame-outline"
      :disabled="!props?.links[props?.links.length - 1].url"
      @click.prevent="
        () => handleClick(props?.links[props?.links.length - 1].url)
      "
    >
      Next
      <ChevronRightIcon class="size-5" />
    </button>
  </div>
</template>

<style scoped></style>
