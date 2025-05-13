<template>
  <AddProperty />
</template>

<script setup>
import { ref } from "vue";
import BackendLayout from "@/layouts/backend-layout.vue";
import AddProperty from "@/backend/components/add-property.vue";
const toggle = ref(true);

function toggled() {
  toggle.value = !toggle.value;
}
</script>

<script>
export default {
  layout: BackendLayout,
};
</script>

<style lang="scss" scoped></style>
