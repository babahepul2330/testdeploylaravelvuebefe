import { storeToRefs } from "pinia";
import { useOrderStore } from "@/stores/order";

export default function checkCart(to, from, next) {
  const store = useOrderStore();
  const { cart } = storeToRefs(store);

  if (
    to.meta.haveCart &&
    Object.values(cart?.value).filter(Boolean).length === 0
  ) {
    next(from);
  } else {
    next();
  }
}
