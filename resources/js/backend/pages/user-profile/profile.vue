<template>
 <Profile :userdata="userdata" :address="address" :personalInformation="personalInformation" :formattedDateOfBirth="formattedDateOfBirth" :properties="properties"/>
</template>

<script setup>
import BackendLayout from "@/layouts/backend-layout.vue";
import Profile from "@/backend/components/user-profile/profile.vue";
import { usePage } from "@inertiajs/vue3";

const { props } = usePage();
const { userdata, address, personalInformation,formattedDateOfBirth,properties } = props; 
</script>

<script>
export default {
  layout: BackendLayout,
};
</script>

<style lang="scss" scoped></style>
