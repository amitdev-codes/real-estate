<template>
  <Dashboard />
</template>

<script setup>
import Dashboard from "@/backend/components/dashboard.vue";
</script>


<script>
import BackendLayout from "@/layouts/backend-layout.vue";
export default {
    layout: BackendLayout,
};
</script>

<style lang="scss" scoped></style>
