<!-- BasicInfo.vue -->
<template>
  <TextElement
    name="first_name"
    label="First Name"
    rules="required"
    size="sm"
    :columns="6"
    :default="props.data.first_name"
  />
  <TextElement
    name="last_name"
    label="Last Name"
    rules="required"
    size="sm"
    :columns="6"
    :default="props.data.last_name"
  />
  <TextElement
    name="email"
    label="Email"
    rules="required"
    size="sm"
    type="email"
    :columns="6"
    :default="props.data.email"
  />
  <PhoneElement
    name="phone"
    label="Mobile Number"
    :allow-incomplete="true"
    :unmask="true"
    :include="['Au', 'us', 'gb', 'de', 'np']"
    rules="required"
    size="sm"
    :columns="6"
    :default="props.data.phone"
  />
</template>

<script setup>
const props = defineProps({
  data: {
    type: Object,
    default: () => ({}),
  },
});

const emit = defineEmits(["update"]);
</script>
