import { storeToRefs } from "pinia";
import { useAuthStore } from "@/stores/auth";

export default async function initAuthStoreMiddleware(to, from, next) {
  const store = useAuthStore();
  const { initialized } = storeToRefs(store);

  if (!initialized.value) {
    await store.initialize();
    initialized.value = true;
  }

  next();
}
