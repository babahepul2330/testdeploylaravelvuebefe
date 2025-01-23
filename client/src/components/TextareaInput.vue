<script setup>
const props = defineProps({
  label: { required: true, type: String },
  placeholder: { required: true, type: String },
  name: { required: true, type: String },
  reactiveState: { required: true },
  errors: { required: false, type: Object },
  disabled: { required: false, type: Boolean, default: false },
});
</script>

<template>
  <label class="form-control w-full">
    <div class="label">
      <span class="label-text">{{ props.label }}</span>
    </div>
    <textarea
      :placeholder="props.placeholder"
      class="textarea textarea-bordered h-24 max-h-52"
      v-model="props.reactiveState[props.name]"
      :readonly="props.disabled"
    ></textarea>
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
