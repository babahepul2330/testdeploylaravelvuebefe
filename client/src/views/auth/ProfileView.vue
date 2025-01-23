<script setup>
import { computed, reactive, ref } from "vue";
import { RouterLink, useRouter } from "vue-router";
import { storeToRefs } from "pinia";
import { toast } from "@steveyuowo/vue-hot-toast";
import { useAuthStore } from "@/stores/auth";
import ButtonLoader from "@/components/ButtonLoader.vue";
import ROUTES from "@/common/constants/routes";

const router = useRouter();
const store = useAuthStore();
const { user, isVerified, error, errors, isLoading, message } = storeToRefs(store);

const previewImage = ref(null)
const form = reactive({
  biodata: user?.value?.profile?.biodata,
  age: user?.value?.profile?.age,
  address: user?.value?.profile?.address,
  image: user?.value?.profile?.image,
})

function handleFileChange(e) {
  if (e.target.files.length > 0) {
    form.image = e.target.files[0]
    previewImage.value = URL.createObjectURL(e.target.files[0])
  }
}

async function handlerSubmit() {
  await store.updateProfile(form);

  if (error.value || errors.value) {
    toast.error(message.value, { position: "top-right" });
  } else {
    toast.success(message.value, { position: "top-right" });
  }
}
</script>

<template>
  <div class="profile-container w-full max-w-4xl mx-auto">
    <div class="profile-card bg-gray-100 text-center p-10 w-full">
      <h1 class="text-2xl font-bold mb-8">My Profile</h1>

      <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="col-span-1 flex flex-col items-center justify-start mb-8">
          <div class="avatar">
            <div class="mb-5 ring-primary ring-offset-base-100 w-36 rounded-full ring ring-offset-2 bg-base-300">
              <img
                :src="previewImage ?? form.image ?? `https://placehold.co/600x400?text=${user?.name}`"
                :alt="user?.name"
              />
            </div>
          </div>

          <input type="file" id="file" accept="image/*" class="hidden" @change="handleFileChange" />
          <label for="file" type="button" class="btn btn-sm btn-frame-outline rounded">Change</label>
        </div>

        <div class="col-span-1">
          <div class="info-item">
            <input type="text" class="input input-bordered input-sm rounded w-full" :value="user.name" readonly />
          </div>
          <div class="info-item">
            <label class="input input-bordered input-secondary focus:outline-offset-1 input-sm rounded w-full flex items-center gap-2">
              <input type="email" class="grow" :value="user.email" readonly />
              <span v-if="isVerified" class="badge badge-sm badge-success">Verified</span>
              <span v-else class="badge badge-sm badge-error">Unverified</span>
            </label>
          </div>
          <div class="info-item">
            <input type="text" class="input input-bordered input-sm rounded w-full" placeholder="Age" v-model="form.age" />
          </div>
          <div class="info-item">
            <input type="text" class="input input-bordered input-sm rounded w-full" placeholder="Address" v-model="form.address" />
          </div>
          <div class="info-item">
            <textarea class="textarea textarea-bordered textarea-sm rounded w-full max-h-24" placeholder="Biodata" v-model="form.biodata"></textarea>
          </div>

          <button v-if="isVerified" type="button" class="btn btn-frame-outline rounded mt-3" @click="handlerSubmit" :disabled="isLoading">
            <ButtonLoader :is-loading="isLoading" text="Update" />
          </button>
          <RouterLink v-else :to="ROUTES.verify" class="btn btn-frame-outline rounded mt-3">
            Verify Account
          </RouterLink>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.profile-container {
  align-items: center;
  display: flex;
  padding: 20px;
}

/* Card untuk profil */
.profile-card {
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  /* max-width: 600px; Batas lebar */
  width: 100%;
}

.profile-info {
  font-family: Arial, sans-serif;
  color: #4a4a4a;
}

.info-item {
  display: flex;
  align-items: center;
  margin-bottom: 16px;
}

.info-item strong {
  font-size: 14px;
  color: #4a4a4a;
}

.info-item p {
  margin: 4px 0 0;
  font-size: 14px;
  color: #6a6a6a;
}
</style>
