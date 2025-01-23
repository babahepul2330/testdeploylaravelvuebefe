<script setup>
import { reactive } from "vue";
import { useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { toast } from "@steveyuowo/vue-hot-toast";
import { useAuthStore } from "@/stores/auth";
import ButtonLoader from "@/components/ButtonLoader.vue";
import TextInput from "@/components/TextInput.vue";
import ROUTES from "@/common/constants/routes";

const router = useRouter()
const store = useAuthStore();
const { message, error, errors, isLoading } = storeToRefs(store);

const form = reactive({
  otp: "",
});

async function handleVerify() {
  await store.verifyAccount(form);

  if (error.value || errors.value) {
    toast.error(message.value, { position: "top-right" });
  } else {
    router.push(ROUTES.profile)
    toast.success(message.value, { position: "top-right" });
  }
}

async function handleGenerate() {
  await store.generateToken();

  if (error.value || errors.value) {
    toast.error(message.value, { position: "top-right" });
  } else {
    toast.success(message.value, { position: "top-right" });
  }
}
</script>

<template>
  <div class="min-h-[55svh] w-full flex items-center justify-center">
    <div class="card box-frame w-full max-w-md">
      <div class="card-body">
        <h1 class="card-title m-0">Verify Account</h1>

        <form
          class="inline-flex items-start gap-3 w-full mb-5"
          @submit.prevent="handleVerify"
        >
          <div class="flex-1">
            <TextInput
              label=""
              placeholder="OTP"
              name="otp"
              type="text"
              :errors="errors"
              :reactive-state="form"
            />
          </div>
          <div>
            <div class="label"><span class="label-text"></span></div>
            <button type="submit" class="btn btn-frame" :disabled="isLoading">
              Verify
            </button>
          </div>
        </form>

        <button
          type="button"
          class="btn btn-ghost btn-sm"
          @click="handleGenerate"
          :disabled="isLoading"
        >
          <ButtonLoader :is-loading="isLoading" text="Regenerate OTP Code" />
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
