export default [
  {
    path: "/admin",
    component: () => import("@/views/admin/IndexView.vue"),
    meta: {
      requireAuth: true,
      requireRoleAdmin: true,
      layout: "AdminLayout",
    },
  },
  {
    path: "/admin/category",
    meta: {
      requireAuth: true,
      requireRoleAdmin: true,
      layout: "AdminLayout",
    },
    children: [
      {
        path: "",
        component: () => import("@/views/admin/category/IndexView.vue"),
      },
      {
        path: "create",
        component: () => import("@/views/admin/category/CreateView.vue"),
      },
      {
        path: ":id/edit",
        component: () => import("@/views/admin/category/EditView.vue"),
      },
    ],
  },
  {
    path: "/admin/product",
    meta: {
      requireAuth: true,
      requireRoleAdmin: true,
      layout: "AdminLayout",
    },
    children: [
      {
        path: "",
        component: () => import("@/views/admin/product/IndexView.vue"),
      },
      {
        path: "create",
        component: () => import("@/views/admin/product/CreateView.vue"),
      },
      {
        path: ":id/edit",
        component: () => import("@/views/admin/product/EditView.vue"),
      },
    ],
  },
  {
    path: "/admin/order",
    meta: {
      requireAuth: true,
      requireRoleAdmin: true,
      layout: "AdminLayout",
    },
    children: [
      {
        path: "",
        component: () => import("@/views/admin/order/IndexView.vue"),
      },
      {
        path: ":id",
        component: () => import("@/views/admin/order/ShowView.vue"),
      },
    ],
  },
];
