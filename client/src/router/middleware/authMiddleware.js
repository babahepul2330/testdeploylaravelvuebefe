import { storeToRefs } from "pinia";
import { useAuthStore } from "@/stores/auth";
import ROUTES from "@/common/constants/routes";

export function isAuthenticated(to, from, next) {
  const store = useAuthStore();
  const { user } = storeToRefs(store);

  if (to.meta.requireAuth && !user.value) next(ROUTES.login);
  else next();
}

export function isGuest(to, from, next) {
  const store = useAuthStore();
  const { user } = storeToRefs(store);

  if (to.meta.ensureGuest && !!user.value) next(from);
  else next();
}
