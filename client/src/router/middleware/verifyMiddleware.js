import { storeToRefs } from "pinia";
import { useAuthStore } from "@/stores/auth";
import ROUTES from "@/common/constants/routes";

export function mustVerify(to, from, next) {
  const store = useAuthStore();
  const { isVerified } = storeToRefs(store);

  if (to.meta.ensureVerify && !isVerified.value) next(ROUTES.verify);
  else next();
}

export function mustUnverify(to, from, next) {
  const store = useAuthStore();
  const { isVerified } = storeToRefs(store);

  if (to.meta.ensureUnverify && isVerified.value) next(from);
  else next();
}
