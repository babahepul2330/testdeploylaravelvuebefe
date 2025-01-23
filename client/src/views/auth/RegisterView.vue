<script setup>
import { onMounted, reactive } from "vue";
import { RouterLink } from "vue-router";
import { storeToRefs } from "pinia";
import { toast } from "@steveyuowo/vue-hot-toast";
import { useAuthStore } from "@/stores/auth";
import TextInput from "@/components/TextInput.vue";
import ButtonLoader from "@/components/ButtonLoader.vue";
import ROUTES from "@/common/constants/routes";

const store = useAuthStore();
const { error, errors, isLoading, message } = storeToRefs(store);

const form = reactive({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

onMounted(() => {
  store.resetState();
});

function clearForm() {
  form.name = "";
  form.email = "";
  form.password = "";
  form.password_confirmation = "";
}

async function handlerSubmit() {
  await store.register(form);

  if (error.value || errors.value) {
    toast.error(message.value, { position: "top-right" });
  } else {
    clearForm();
    toast.success(message.value, { position: "top-right" });
  }
}
</script>

<template>
  <div class="w-full h-full">
    <form @submit.prevent="handlerSubmit">
      <div class="card box-frame bg-pink-100 w-full max-w-sm mx-auto">
        <div class="card-body">
          <h1 class="card-title mb-3 text-center">
            Regist account <span class="font-black">E-Commerce</span>
          </h1>

          <TextInput
            label="Name"
            placeholder="Type your name"
            name="name"
            type="text"
            :errors="errors"
            :reactive-state="form"
          />

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

          <TextInput
            label="Confirm Password"
            placeholder="********"
            name="password_confirmation"
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
              <ButtonLoader :is-loading="isLoading" text="Register" />
            </button>
          </div>

          <label class="form-control w-full max-w-sm">
            <div class="label">
              <span class="label-text">
                Already have account? Sign in
                <RouterLink
                  :to="ROUTES.login"
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
