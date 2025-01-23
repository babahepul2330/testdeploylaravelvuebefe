<script setup>
import { onMounted, reactive } from "vue";
import { RouterLink, useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { toast } from "@steveyuowo/vue-hot-toast";
import { useAuthStore } from "@/stores/auth";
import TextInput from "@/components/TextInput.vue";
import ButtonLoader from "@/components/ButtonLoader.vue";
import ROUTES from "@/common/constants/routes";

const router = useRouter();
const store = useAuthStore();
const { error, errors, isLoading, message } = storeToRefs(store);

const form = reactive({
  email: "",
  password: "",
});

onMounted(() => {
  store.resetState();
});

function clearForm() {
  form.email = "";
  form.password = "";
}

async function handlerSubmit() {
  await store.login(form);

  if (error.value || errors.value) {
    toast.error(message.value, { position: "top-right" });
  } else {
    clearForm();
    router.push(ROUTES.index);
    toast.success(message.value, { position: "top-right" });
  }
}
</script>

<template>
  <div class="w-full h-full">
    <form @submit.prevent="handlerSubmit">
      <div class="card box-frame bg-emerald-100 w-full max-w-sm mx-auto">
        <div class="card-body">
          <h1 class="card-title mb-3 text-center">
            Login <span class="font-black">E-Commerce</span>
          </h1>

          <TextInput
            label="Email"
            placeholder="your@mail.yup"
            name="email"
            type="email"
            :errors="errors"
            :reactive-state="form"
          />

          <TextInput
            label="Password"
            placeholder="********"
            name="password"
            type="password"
            :errors="errors"
            :reactive-state="form"
          />

          <div class="card-action mt-8">
            <button
              type="submit"
              class="btn btn-primary w-full"
              :disabled="isLoading"
            >
              <ButtonLoader :is-loading="isLoading" text="Login" />
            </button>
          </div>

          <label class="form-control w-full max-w-sm">
            <div class="label">
              <span class="label-text">
                Dont have account? Sign up
                <RouterLink
                  :to="ROUTES.register"
                  class="font-bold underline underline-offset-2 decoration-2"
                >
                  Here
                </RouterLink>
              </span>
            </div>
          </label>
        </div>
      </div>
    </form>
  </div>
</template>

<style scoped></style>
