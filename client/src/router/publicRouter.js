export default [
  {
    path: "/",
    component: () => import("@/views/public/IndexView.vue"),
  },
  {
    path: "/product",
    children: [
      {
        path: "",
        component: () => import("@/views/public/product/IndexView.vue"),
      },
      {
        path: ":id",
        component: () => import("@/views/public/product/ShowView.vue"),
      },
    ],
  },
  {
    path: "/category",
    children: [
      {
        path: "",
        component: () => import("@/views/public/category/IndexView.vue"),
      },
      {
        path: ":id",
        component: () => import("@/views/public/category/ShowView.vue"),
      },
    ],
  },
  {
    path: "/order",
    meta: { requireAuth: true },
    children: [
      {
        path: "",
        component: () => import("@/views/public/order/IndexView.vue"),
      },
      {
        path: "create",
        component: () => import("@/views/public/order/CreateView.vue"),
        meta: { haveCart: true, ensureVerify: true },
      },
      {
        path: ":id",
        component: () => import("@/views/public/order/ShowView.vue"),
      },
    ],
  },
];
