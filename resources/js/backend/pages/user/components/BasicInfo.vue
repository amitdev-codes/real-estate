<!-- BasicInfo.vue -->
<template>
      <GroupElement name="personal_information" label="Personal information">
        <TextElement
          name="name"
          label="Your Name"
          rules="required"
          size="sm"
          :default="props.selectedResource?.name || ''"
        />
      </GroupElement>
      <GroupElement name="contact_information" label="Contact information">
        <PhoneElement
          name="mobile_no"
          label="Mobile Number"
          :allow-incomplete="true"
          :unmask="true"
          :include="['Au', 'us', 'gb', 'de', 'np']"
          rules="required"
          size="sm"
          :default="props.selectedResource?.mobile_no || '61'"
          :columns="6"
        />
        <TextElement
          name="email"
          label="Email"
          rules="required"
          size="sm"
          type="email"
          :default="props.selectedResource?.email"
          :columns="6"
        />
      </GroupElement>

      <SelectElement
        label="Role"
        name="role"
        :native="false"
        :items="roles"
        size="sm"
        :default="defaultRoleId"
        :columns="6"
      />
      <TextElement
        :conditions="[['role', '==', '3']]"
        name="license_number"
        label="License Number"
        rules="required"
        size="sm"
        :columns="6"
      />
      <TextElement
        :conditions="[['role', '==', '4']]"
        name="agency_id"
        label="Agency ID"
        rules="required|max:255"
        :debounce="300"
        size="sm"
        :columns="6"
      />

      <GroupElement name="crednetials_information" label="Credentials information">
        <TextElement
          label="Password"
          name="password"
          input-type="password"
          :columns="6"
          :rules="
            isEditMode
              ? []
              : [
                  'required',
                  'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/',
                  'confirmed',
                ]
          "
          :debounce="300"
          size="sm"
          :messages="{
            regex:
              'The Password must at least 8 characters long and contain at least one number, one uppercase and one lowercase character.',
          }"
        />
        <TextElement
          label="Confirm Password"
          name="password_confirmation"
          input-type="password"
          :rules="isEditMode ? [] : 'required'"
          size="sm"
          :columns="6"
        />
      </GroupElement>
      <ToggleElement
        name="status_id"
        :true-value="true"
        :false-value="false"
        :default="props.selectedResource?.status_id ?? true"
      >
        Status
      </ToggleElement>
  </template>

  <script setup>
  import { usePage } from "@inertiajs/vue3";

  const props = defineProps({
    data: {
      type: Object,
      default: () => ({}),
    },
    selectedResource: {
      type: Object,
      default: null,
    },
  });

  const emit = defineEmits(["update"]);
  const roles = usePage().props.roles.map((role) => ({
    value: role.id,
    label: role.name,
}));
  </script>
