<script setup>
import { computed, reactive, ref, watch } from "vue";
import { RouterLink, useRoute, useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { MagnifyingGlassIcon, PlusIcon } from "@heroicons/vue/24/solid";
import { toast } from "@steveyuowo/vue-hot-toast";
import { useCategoryStore } from "@/stores/category";
import BreadCrumb from "@/components/BreadCrumb.vue";
import TableRender from "@/components/TableRender.vue";
import ROUTES from "@/common/constants/routes";

const route = useRoute();
const router = useRouter();
const store = useCategoryStore();
const params = computed(() => route.query);
const { data, isLoading, message, error, errors } = storeToRefs(store);

const rows = computed(() => [
  { title: "Name", data: "name" },
  {
    title: "Action",
    routeEdit: { route: ROUTES.admin.category.edit, params: ["id"] },
    handleDelete: handlerDelete,
  },
]);

const breadcrumbs = ref([
  { title: "Dashboard", route: ROUTES.admin.index },
  { title: "Category", route: ROUTES.admin.category.index, current: true },
]);

const form = reactive({
  search: params?.value?.search ?? ""
})

watch(
  params,
  (newQs, oldQs) => {
    store.getAllData({ ...params.value });
  },
  { immediate: true }
);

function handleSearch() {
  router.push({
    path: ROUTES.admin.category.index,
    query: form
  })
}

async function handlerDelete(data) {
  await store.deleteData(data.id);

  if (error.value || errors.value) {
    toast.error(message.value, { position: "top-right" });
  } else {
    toast.success(message.value, { position: "top-right" });
    await store.getAllData();
  }
}
</script>

<template>
  <div>
    <BreadCrumb :items="breadcrumbs" />

    <div class="flex flex-col lg:flex-row w-full mt-5 mb-8 gap-4">
      <h1 class="flex-1 text-2xl font-bold">List Category</h1>

      <div class="inline-flex items-center justify-between gap-5">
        <form class="join" @submit.prevent="handleSearch">
          <input v-model="form.search" class="input input-bordered input-sm w-36 sm:w-44 join-item" />
          <button type="submit" class="btn btn-frame-outline btn-sm join-item">
            <MagnifyingGlassIcon class="size-4" />
            <span class="hidden sm:inline">Search</span>
          </button>
        </form>

        <RouterLink :to="ROUTES.admin.category.create" class="flex-none btn btn-frame-outline btn-success btn-sm">
          <PlusIcon class="size-4" />
          <span class="hidden sm:inline">Create</span>
        </RouterLink>
      </div>
    </div>

    <TableRender :pagination="data?.categories" :rows="rows" :isLoading="isLoading" />
  </div>
</template>

<style scoped></style>
