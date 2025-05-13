<template>
  <TextElement
    name="name"
    label="Name"
    rules="required"
    size="sm"
    :columns="4"
    :default="props.data.user.name"
  />
  <TextElement
    name="email"
    label="Email"
    rules="required"
    size="sm"
    type="email"
    :columns="4"
    :default="props.data.user.email"
  />
  <PhoneElement
    name="mobile_no"
    label="Mobile Number"
    :allow-incomplete="true"
    :unmask="true"
    :include="['Au', 'us', 'gb', 'de', 'np']"
    rules="required"
    size="sm"
    :columns="4"
    :default="props.data.user.mobile_number"
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
