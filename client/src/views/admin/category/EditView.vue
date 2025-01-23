<script setup>
import { computed, onBeforeMount, onMounted, reactive, ref } from "vue";
import { RouterLink, useRoute, useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { ChevronLeftIcon } from "@heroicons/vue/24/solid";
import { toast } from "@steveyuowo/vue-hot-toast";
import { useCategoryStore } from "@/stores/category";
import BreadCrumb from "@/components/BreadCrumb.vue";
import TextInput from "@/components/TextInput.vue";
import ButtonLoader from "@/components/ButtonLoader.vue";
import ROUTES from "@/common/constants/routes";

const route = useRoute();
const router = useRouter();
const categoryStore = useCategoryStore();
const { data, isLoading, message, error, errors } = storeToRefs(categoryStore);

const breadcrumbs = ref([
  { title: "Dashboard", route: ROUTES.admin.index },
  { title: "Category", route: ROUTES.admin.category.index },
  { title: "Edit", current: true },
]);

const form = computed(() => {
  return reactive({
    name: data?.value?.category?.name,
  });
});

onBeforeMount(() => {
  categoryStore.getData(route.params?.id);
});

onMounted(() => {
  categoryStore.resetState();
});

function clearForm() {
  form.name = "";
}

async function handlerSubmit() {
  await categoryStore.editData(route.params?.id, form.value);

  if (error.value || errors.value) {
    toast.error(message.value, { position: "top-right" });
  } else {
    clearForm();
    router.push(ROUTES.admin.category.index);
    toast.success(message.value, { position: "top-right" });
  }
}
</script>

<template>
  <div>
    <BreadCrumb :items="breadcrumbs" />

    <div class="inline-flex w-full mt-5 mb-8">
      <h1 class="flex-1 text-2xl font-bold">Edit Category</h1>

      <RouterLink
        :to="ROUTES.admin.category.index"
        class="flex-none btn btn-frame-outline btn-success btn-sm"
      >
        <ChevronLeftIcon class="size-4" />
        <span>Back</span>
      </RouterLink>
    </div>

    <form @submit.prevent="handlerSubmit">
      <div
        class="card box-frame bg-orange-100 w-full md:max-w-xl lg:md:max-w-lg mx-auto"
      >
        <div class="card-body">
          <TextInput
            label="Category Name"
            placeholder="Sport, Hobby, Asian Food"
            name="name"
            type="text"
            :errors="errors"
            :reactive-state="form"
          />

          <div class="card-action mt-8">
            <button
              type="submit"
              class="btn btn-primary w-full"
              :disabled="isLoading"
            >
              <ButtonLoader :is-loading="isLoading" text="Edit" />
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<style scoped></style>
