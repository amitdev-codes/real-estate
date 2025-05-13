<template>
  <CreateEditModal
    :show="show"
    resourceName="property-developers"
    modelName="propertyDeveloper"
    :itemId="selectedResource?.id"
    :isEditMode="isEditMode"
    :formData="form"
    @close="emit('close')"
    @save="handleSubmit"
    @formSubmitted="handleFormSuccess"
    @formError="handleFormError"
    @resetForm="resetForm"
  >
    <!-- Body Slot -->
    <template #formBody>
      <form>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
          <!-- Name Field -->
          <TextInput
            v-model="form.name"
            type="text"
            label="Name"
            id="name"
            placeholder="Enter Name"
            :required="true"
          />
          <!-- Email Field -->

          <TextInput
            v-model="form.email"
            type="email"
            label="Email"
            id="email"
            placeholder="Enter email"
            :required="true"
          />

          <!-- Mobile Number Field -->
          <MobileInput
            v-model="form.mobile_no"
            id="mobile_no"
            label="Mobile Number"
            countryCode="+977"
          />

        </div>
      </form>
    </template>
  </CreateEditModal>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import CreateEditModal from "@/backend/components/modals/CreateEditModal.vue";
import { usePage } from "@inertiajs/vue3";
import TextInput from "@/backend/components/ui/inputs/TextInput.vue";
import MobileInput from "@/backend/components/ui/inputs/MobileNumberInput.vue";

const props = defineProps({
  show: { type: Boolean, default: false },
  selectedResource: { type: Object, default: null },
});

const { props: pageProps } = usePage();

const emit = defineEmits(["close", "save", "updated"]);

const form = ref({
  name: computed({
    get: () => props.selectedResource?.name || "",
    set: (value) => {
      form.value.name = value;
    },
  }),
  email: computed({
    get: () => props.selectedResource?.email || "",
    set: (value) => {
      form.value.email = value;
    },
  }),
  mobile_no: computed({
    get: () => props.selectedResource?.mobile_no || "",
    set: (value) => {
      form.value.mobile_no = value;
    },
  }),

  roles: [],
  status: false,
});

const errors = ref({});
const isEditMode = computed(() => !!props.selectedResource?.id);

const resetForm = () => {
  form.value = {
    name: "",
    email: "",
    mobile_no: "",
  };
  errors.value = {};
};

watch(
  () => props.selectedResource,
  (newselectedResource) => {
    if (newselectedResource) {
      form.value = {
        name: newselectedResource.name || "",
        email: newselectedResource.email || "",
        mobile_no: newselectedResource.mobile_no || "",
      };
    } else {
      resetForm();
    }
  },
  { immediate: true }
);
const handleFormSuccess = () => {
  emit("updated");
  emit("close");
};

const handleFormError = (serverErrors) => {
  errors.value = serverErrors;
};
</script>
