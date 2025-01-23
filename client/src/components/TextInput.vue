<script setup>
const props = defineProps({
  label: { required: true, type: String },
  type: { required: true, type: String },
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
    <input
      :type="props.type"
      :placeholder="props.placeholder"
      class="input input-bordered w-full bg-base-100"
      :readonly="props.disabled"
      v-model="props.reactiveState[props.name]"
    />
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
