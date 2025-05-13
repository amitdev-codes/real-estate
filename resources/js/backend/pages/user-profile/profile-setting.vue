<template>
  <ProfileSetting :userdata="userdata" :address="address" :personalInformation="personalInformation"/>
</template>

<script setup>
import ProfileSetting from "@/backend/components/user-profile/profile-setting.vue";
import BackendLayout from "@/layouts/backend-layout.vue";

import { usePage } from "@inertiajs/vue3";

const { props } = usePage();
const { userdata, address, personalInformation } = props; 
</script>

<script>
export default {
  layout: BackendLayout,
};
</script>

<style lang="scss" scoped></style>
