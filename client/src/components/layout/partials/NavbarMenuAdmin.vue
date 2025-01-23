<script setup>
import { computed } from "vue";
import { RouterLink, useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { toast } from "@steveyuowo/vue-hot-toast";
import { useAuthStore } from "@/stores/auth";
import ROUTES from "@/common/constants/routes";

const router = useRouter();
const store = useAuthStore();
const { user, error, errors, message } = storeToRefs(store);

const routes = computed(() => [
  { title: "Dashboard", route: ROUTES.admin.index },
  { title: "Category", route: ROUTES.admin.category.index },
  { title: "Product", route: ROUTES.admin.product.index },
  { title: "Order", route: ROUTES.admin.order.index },
  {
    title: "Logout",
    route: "",
    class: "btn btn-frame w-full mt-8",
    show: user.value,
    click: handleLogout,
  },
]);

async function handleLogout() {
  await store.logout();

  if (error.value || errors.value) {
    toast.error(message.value, { position: "top-right" });
  } else {
    store.resetData();
    store.resetState();
    router.push(ROUTES.index);
  }
}
</script>

<template>
  <ul
    class="menu md:menu-horizontal items-start md:items-center bg-base-100 rounded-box p-0 gap-3 w-full"
  >
    <template v-for="(item, idx) in routes" :key="idx">
      <li class="w-full">
        <RouterLink
          v-if="!item.click"
          :to="item.route"
          :class="item.class"
          activeClass="active"
        >
          {{ item.title }}
        </RouterLink>
        <a v-else :class="item.class" @click.prevent="item.click">
          {{ item.title }}
        </a>
      </li>
    </template>
  </ul>
</template>

<style scoped></style>
