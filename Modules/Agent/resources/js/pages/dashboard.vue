<template>
  <Dashboard :data="data" />
</template>

<script setup>
import BackendLayout from "@/layouts/backend-layout.vue";
import Dashboard from "../components/dashboard.vue";

const props = defineProps({
  data: {
    type: Object,
  },
});
</script>

<script>
export default {
  layout: BackendLayout,
};
</script>
<style></style>
