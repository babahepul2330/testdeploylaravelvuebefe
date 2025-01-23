import { createRouter, createWebHistory } from "vue-router";
import adminRouter from "./adminRouter";
import publicRouter from "./publicRouter";
import authRouter from "./authRouter";
import loadLayoutMiddleware from "./middleware/loadLayoutMiddleware";
import { isRoleAdmin } from "./middleware/roleMiddleware";
import initAuthStoreMiddleware from "./middleware/initAuthStoreMiddleware";
import checkCart from "./middleware/checkChartMiddleware";
import { mustUnverify, mustVerify } from "./middleware/verifyMiddleware";
import { isAuthenticated, isGuest } from "./middleware/authMiddleware";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    ...authRouter,
    ...publicRouter,
    ...adminRouter,
    {
      path: "/:pathMatch(.*)*",
      name: "NotFound",
      component: () => import("@/views/error/NotFound.vue"),
    },
  ],
});

router.beforeResolve(initAuthStoreMiddleware);
router.beforeResolve(isGuest);
router.beforeResolve(isAuthenticated);
router.beforeResolve(isRoleAdmin);
router.beforeEach(loadLayoutMiddleware);
router.beforeEach(checkCart);
router.beforeEach(mustUnverify);
router.beforeEach(mustVerify);

export default router;
