<script setup>
import { computed } from "vue";
import { RouterLink, useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { toast } from "@steveyuowo/vue-hot-toast";
import { useAuthStore } from "@/stores/auth";
import ROUTES from "@/common/constants/routes";

const router = useRouter();
const store = useAuthStore();
const { isAdmin, user, error, errors, message } = storeToRefs(store);

const routes = computed(() => [
  { title: "Product", route: ROUTES.product.index, show: true },
  { title: "Category", route: ROUTES.category.index, show: true },
  { title: "Order", route: ROUTES.order.index, show: user.value },
  { title: "Profile", route: ROUTES.profile, show: user.value },
  {
    title: "Administrator",
    route: ROUTES.admin.index,
    show: user.value && isAdmin.value,
  },
  {
    title: "Register",
    route: ROUTES.register,
    class: `btn btn-frame-outline w-full md:w-auto md:min-w-24 md:hidden lg:inline-flex`,
    show: !user.value,
  },
  {
    title: "Login",
    route: ROUTES.login,
    class: "btn btn-frame w-full md:w-auto md:min-w-24",
    show: !user.value,
  },
  {
    title: "Logout",
    route: "",
    class: "btn btn-frame w-full md:w-auto md:min-w-24",
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
    class="menu md:menu-horizontal items-start md:items-center bg-base-100 rounded-box p-0 gap-3"
  >
    <template v-for="(item, idx) in routes" :key="idx">
      <li v-show="item.show" class="w-full md:w-auto">
        <RouterLink
          v-if="!item.click"
          :to="item.route"
          :class="item.class"
          tabindex="-1"
        >
          {{ item.title }}
        </RouterLink>
        <a v-else :class="item.class" @click.prevent="item.click" tabindex="-1">
          {{ item.title }}
        </a>
      </li>
    </template>
  </ul>
</template>

<style scoped></style>
