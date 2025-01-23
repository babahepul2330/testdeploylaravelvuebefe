<script setup>
import { computed } from "vue";
import { RouterLink } from "vue-router";
import { parseRoute } from "@/common/utils/routes";
import PaginationLink from "./PaginationLink.vue";

const { isLoading, pagination, rows } = defineProps([
  "rows",
  "pagination",
  "isLoading",
]);

const from = computed(() => pagination?.from);
const data = computed(() => pagination?.data);
const links = computed(() => pagination?.links);
const currentPage = computed(() => pagination?.current_page);

function getParams(arr = [], data = {}) {
  return arr?.map((item) => data[item]);
}

function getRoute(row = {}, item = {}, type = "routeEdit") {
  const route = row?.[type]?.route;
  const params = row?.[type]?.params;

  return parseRoute(route, getParams(params, item));
}
</script>

<template>
  <div class="overflow-x-auto">
    <table class="table table-pin-rows table-pin-cols">
      <thead>
        <tr>
          <th></th>
          <td
            v-for="(item, idx) in rows"
            :key="idx"
            class="text-center text-sm"
          >
            {{ item.title }}
          </td>
        </tr>
      </thead>
      <tbody>
        <template v-if="isLoading">
          <tr>
            <td :colspan="rows.length + 1" class="text-center">Loading...</td>
          </tr>
        </template>
        <template v-else>
          <template v-if="data?.length > 0">
            <tr v-for="(item, idx) in data" :key="idx">
              <th class="text-center">{{ from + idx }}</th>
              <template v-for="(row, idx) in rows" :key="idx">
                <td v-if="row.data" :class="row?.class">
                  {{ item[row.data] }}
                </td>

                <td
                  v-else
                  class="w-full inline-flex gap-3 items-center justify-center"
                >
                  <RouterLink
                    v-if="row.routeShow"
                    :to="getRoute(row, item, 'routeShow')"
                    class="btn btn-frame-outline btn-warning btn-sm"
                  >
                    Detail
                  </RouterLink>

                  <RouterLink
                    v-if="row.routeEdit"
                    :to="getRoute(row, item)"
                    class="btn btn-frame-outline btn-warning btn-sm"
                  >
                    Edit
                  </RouterLink>

                  <button
                    v-if="row.handleEdit"
                    @click.prevent="() => row.handleEdit(item.id)"
                    class="btn btn-frame-outline btn-warning btn-sm"
                  >
                    Edit
                  </button>

                  <button
                    v-if="row.handleDelete"
                    @click.prevent="() => row.handleDelete(item)"
                    class="btn btn-frame-outline btn-danger btn-sm"
                  >
                    Delete
                  </button>
                </td>
              </template>
            </tr>
          </template>
          <template v-else>
            <tr>
              <td :colspan="rows.length + 1" class="text-center">
                Tidak ada data
              </td>
            </tr>
          </template>
        </template>
      </tbody>
    </table>
  </div>

  <div v-if="links" class="flex items-center justify-end w-full my-5 mb-8">
    <PaginationLink :current-page="currentPage" :links="links" />
  </div>
</template>

<style scoped></style>
