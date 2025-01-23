import { storeToRefs } from "pinia";
import { useAuthStore } from "@/stores/auth";

export function isRoleAdmin(to, from, next) {
  const store = useAuthStore();
  const { isAdmin } = storeToRefs(store);

  if (to.meta.requireRoleAdmin && !isAdmin.value) next(from);
  else next();
}
