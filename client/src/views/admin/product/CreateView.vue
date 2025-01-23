<script setup>
import { onMounted, reactive, ref, computed } from "vue";
import { RouterLink, useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { ChevronLeftIcon } from "@heroicons/vue/24/solid";
import { toast } from "@steveyuowo/vue-hot-toast";
import { useProductStore } from "@/stores/product";
import BreadCrumb from "@/components/BreadCrumb.vue";
import TextInput from "@/components/TextInput.vue";
import ButtonLoader from "@/components/ButtonLoader.vue";
import ROUTES from "@/common/constants/routes";
import FileInput from "@/components/FileInput.vue";
import TextareaInput from "@/components/TextareaInput.vue";
import SelectInput from "@/components/SelectInput.vue";
import { useCategoryStore } from "@/stores/category";


const router = useRouter();
const productStore = useProductStore();
const { isLoading, message, error, errors } = storeToRefs(productStore);
const categoryStore = useCategoryStore();
const { data: dataCategory } = storeToRefs(categoryStore);

const categories = computed(() => dataCategory.value?.categories.data.map(item => {
  return {
    name: item.name,
    value: item.id,
  }
}))

const breadcrumbs = ref([
  { title: "Dashboard", route: ROUTES.admin.index },
  { title: "Product", route: ROUTES.admin.product.index },
  { title: "Create", route: ROUTES.admin.product.create, current: true },
]);

const form = reactive({
  name: "",
  category_id: "",
  price: "",
  image: null,
  description: "",
  stock: "",
});

onMounted(async() => {
  productStore.resetState();
  await categoryStore.getAllData({ limit: 1000 });
});

function clearForm() {
  form.name = "";
  form.category_id = "";
  form.price = "";
  form.image = null;
  form.description = "";
  form.stock = "";
}

async function handlerSubmit() {
  await productStore.createData(form);

  if (error.value || errors.value) {
    toast.error(message.value, { position: "top-right" });
  } else {
    clearForm();
    router.push(ROUTES.admin.product.index);
    toast.success(message.value, { position: "top-right" });
  }
}
</script>

<template>
  <div>
    <BreadCrumb :items="breadcrumbs" />

    <div class="inline-flex w-full mt-5 mb-8">
      <h1 class="flex-1 text-2xl font-bold">Create Product</h1>

      <RouterLink
        :to="ROUTES.admin.product.index"
        class="flex-none btn btn-frame-outline btn-success btn-sm"
      >
        <ChevronLeftIcon class="size-4" />
        <span>Back</span>
      </RouterLink>
    </div>

    <form @submit.prevent="handlerSubmit">
      <div
        class="card box-frame bg-blue-100 w-full md:max-w-xl lg:md:max-w-lg mx-auto"
      >

        <div class="card-body">
          <TextInput
            label="Product Name"
            placeholder="Sport, Hobby, Asian Food"
            name="name"
            type="text"
            :errors="errors"
            :reactive-state="form"
          />

          <SelectInput
            label="Categories"
            placeholder="Choose Categories"
            name="category_id"
            :errors="errors"
            :reactive-state="form"
            :options="categories"
          />

          <TextInput
            label="Price"
            placeholder="in Indonesian Rupiah (IDR)"
            name="price"
            type="number"
            :errors="errors"
            :reactive-state="form"
          />

          <TextInput
            label="Stock"
            placeholder="Available Stock"
            name="stock"
            type="number"
            :errors="errors"
            :reactive-state="form"
          />

          <FileInput
            label="Image Product"
            name="image"
            accept="image/*"
            :errors="errors"
            :reactive-state="form"
          />

          <TextareaInput
            label="Description"
            placeholder="Product description"
            name="description"
            :errors="errors"
            :reactive-state="form"
          />

          <div class="card-action mt-8">
            <button
              type="submit"
              class="btn btn-primary w-full"
              :disabled="isLoading"
            >
              <ButtonLoader :is-loading="isLoading" text="Create" />
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<style scoped></style>

