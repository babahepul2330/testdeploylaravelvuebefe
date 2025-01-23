<script setup>
import { EyeIcon } from "@heroicons/vue/24/solid";

const props = defineProps({
  label: { required: true, type: String },
  name: { required: true, type: String },
  accept: { required: true, type: String },
  reactiveState: { required: true },
  errors: { required: false, type: Object },
  disabled: { required: false, type: Boolean, default: false },
});

function handleChange(e) {
  if (e.target.files.length > 0) {
    props.reactiveState[props.name] = e.target.files[0];
  }
}
</script>

<template>
  <label class="form-control w-full">
    <div class="label">
      <span class="label-text">{{ props.label }}</span>
    </div>
    <div class="join w-full">
      <div class="flex-1">
        <input
          type="file"
          :accept="props.accept"
          class="file-input file-input-bordered w-full bg-base-100 join-item"
          @change="handleChange"
          :readonly="props.disabled"
        />
      </div>
      <div
        v-if="typeof props.reactiveState[props.name] === 'string'"
        class="flex-none"
      >
        <a
          :href="props.reactiveState[props.name]"
          target="_blank"
          type="button"
          class="btn btn-frame-outline join-item"
          title="View saved items"
        >
          <EyeIcon class="size-5" />
        </a>
      </div>
    </div>
    <div
      v-if="props.errors && props.errors[props.name]"
      v-for="(msg, idx) in props.errors[props.name]"
      :key="idx"
      class="label"
    >
      <span class="label-text-alt text-red-600">{{ msg }}</span>
    </div>
  </label>
</template>

<style scoped></style>
