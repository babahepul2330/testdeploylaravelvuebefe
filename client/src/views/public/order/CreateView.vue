<script setup>
import { computed, onUnmounted, reactive } from "vue";
import { useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { toast } from "@steveyuowo/vue-hot-toast";
import { useOrderStore } from "@/stores/order";
import TextInput from "@/components/TextInput.vue";
import TextareaInput from "@/components/TextareaInput.vue";
import ButtonLoader from "@/components/ButtonLoader.vue";
import ROUTES from "@/common/constants/routes";
import OrderItem from "@/components/OrderItem.vue";

const router = useRouter();
const store = useOrderStore();
const { cart, data, isLoading, message, error, errors } = storeToRefs(store);

const totalPrice = computed(() => {
  return cart.value.product?.price * cart.value.quantity;
});

const form = reactive({
  first_name: null,
  last_name: null,
  address: null,
  product_id: cart.value.product?.id,
  quantity: cart.value.quantity,
});

onUnmounted(async () => {
  const order = computed(() => data.value?.order);
  store.resetState();
  store.resetData();
  window.snap.hide();

  if (!order) return;

  if (order?.status === "pending") {
    await store.editData(order?.order_id, { status: "cancel" });

    if (error.value || errors.value) {
      toast.error(message?.value, { position: "top-right" });
    } else {
      toast.success("Order canceled", { position: "top-right" });
    }
  }
});

async function handlePay() {
  if (data.value?.snap_token) return;

  await store.createData({ ...form, status: "pending" });

  if (error.value || errors.value) {
    toast.error(message?.value, { position: "top-right" });
  } else {
    toast.success(message?.value, { position: "top-right" });

    window.snap.embed(data.value?.snap_token, {
      embedId: "snap-container",
      onSuccess: (result) => {
        store.editData(result?.order_id, { status: "success" });
        toast.success("Payment success", { position: "top-right" });
        router.push(ROUTES.order.index);
      },
      onPending: (result) => {
        store.editData(result?.order_id, { status: "cancel" });
        toast.success("Payment canceled", { position: "top-right" });
        router.push(ROUTES.index);
      },
      onError: (result) => {
        store.editData(result?.order_id, { status: "cancel" });
        toast.success("Payment canceled", { position: "top-right" });
        router.push(ROUTES.index);
      },
      onClose: () => {
        store.editData(result?.order_id, { status: "cancel" });
        toast.success("Payment canceled", { position: "top-right" });
        router.push(ROUTES.index);
      },
    });
  }
}
</script>

<template>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
    <div class="col-span-1 flex flex-col gap-5">
      <div v-if="!!data?.snap_token" class="card box-frame w-full">
        <div class="card-body">
          <h1 class="card-title text-2xl font-bold border-b-2 border-neutral">
            Item list
          </h1>

          <OrderItem
            :item="{
              ...cart.product,
              quantity: cart.quantity,
              total_price: totalPrice,
            }"
          />
        </div>
      </div>

      <div class="card box-frame w-full">
        <div class="card-body">
          <h1 class="card-title text-2xl font-bold border-b-2 border-neutral">
            Shipping Information
          </h1>

          <div class="">
            <form class="grid grid-cols-2 gap-3">
              <div class="col-span-1">
                <TextInput
                  label="First Name"
                  placeholder="John"
                  name="first_name"
                  type="text"
                  :errors="errors"
                  :reactive-state="form"
                  :disabled="!!data?.snap_token"
                />
              </div>

              <div class="col-span-1">
                <TextInput
                  label="Last Name"
                  placeholder="Doe"
                  name="last_name"
                  type="text"
                  :errors="errors"
                  :reactive-state="form"
                  :disabled="!!data?.snap_token"
                />
              </div>

              <div class="col-span-2">
                <TextareaInput
                  label="Address"
                  placeholder="Bandung, Indonesia"
                  name="address"
                  :errors="errors"
                  :reactive-state="form"
                  :disabled="!!data?.snap_token"
                />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="col-span-1 flex flex-col gap-5">
      <div v-if="!data?.snap_token" class="card box-frame w-full">
        <div class="card-body">
          <h1 class="card-title text-2xl font-bold border-b-2 border-neutral">
            Item list
          </h1>

          <OrderItem
            :item="{
              ...cart.product,
              quantity: cart.quantity,
              total_price: totalPrice,
            }"
          />
        </div>
      </div>

      <div v-if="!data?.snap_token" class="">
        <button
          type="button"
          class="btn btn-frame w-full"
          :disabled="isLoading"
          @click.prevent="handlePay"
        >
          <ButtonLoader :is-loading="isLoading" text="Pay Now" />
        </button>
      </div>

      <div
        v-if="!!data?.snap_token"
        id="snap-container"
        class="w-full h-full"
      ></div>
    </div>
  </div>
</template>

<style scoped></style>
