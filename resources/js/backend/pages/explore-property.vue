<template>
  <Property :property="false" :propertys="false"/>
</template>

<script setup>
import BackendLayout from "@/layouts/backend-layout.vue";
import Property from "@/backend/components/explore-property.vue";
</script>

<script>
export default {
  layout: BackendLayout,
};
</script>

<style lang="scss" scoped></style>

