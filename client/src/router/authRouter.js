import ROUTES from "@/common/constants/routes";

export default [
  {
    path: ROUTES.login,
    name: "login",
    component: () => import("@/views/auth/LoginView.vue"),
    meta: { ensureGuest: true },
  },
  {
    path: ROUTES.register,
    name: "register",
    component: () => import("@/views/auth/RegisterView.vue"),
    meta: { ensureGuest: true },
  },
  {
    path: ROUTES.profile,
    name: "profile",
    component: () => import("@/views/auth/ProfileView.vue"),
    meta: { requireAuth: true },
  },
  {
    path: ROUTES.verify,
    name: 'verify',
    component: () => import('@/views/auth/VerifyView.vue'),
    meta: { requireAuth: true, ensureUnverify: true }
  }
];
