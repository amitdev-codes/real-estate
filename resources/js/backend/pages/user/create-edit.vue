<template>
    <CreateEditVueFormModal
        :show="show"
        resourceName="users"
        modelName="user"
        :itemId="selectedResource?.id"
        :isEditMode="isEditMode"
        :formData="form"
        :validation-rules="rules"
        @close="emit('close')"
        @formSubmitted="handleSuccess"
        @formError="handleFormError"
    >
        <template #form-body>
            <GroupElement
                name="personal_information"
                label="Personal information"
            >
                <TextElement
                    name="name"
                    label="Your Name"
                    rules="required"
                    size="sm"
                    :default="props.selectedResource.name"
                />
            </GroupElement>
            <GroupElement
                name="contact_information"
                label="Contact information"
            >
                <PhoneElement
                    name="mobile_no"
                    label="Mobile Number"
                    :allow-incomplete="true"
                    :unmask="true"
                    :include="['Au', 'us', 'gb', 'de', 'np']"
                    rules="required"
                    size="sm"
                    :default="props.selectedResource.mobile_no || '61'"
                    :columns="6"
                />
                <TextElement
                    name="email"
                    label="Email"
                    rules="required"
                    size="sm"
                    type="email"
                    :default="props.selectedResource.email"
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
                :default="props.selectedResource.license_number"
            />
            <SelectElement
                :conditions="[['role', '==', '3']]"
                name="agency_id"
                label="Agency ID"
                rules="required"
                :native="false"
                :items="agencies"
                size="sm"
                :default="defaultAgencyId"
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
                :default="props.selectedResource.agency_id"
            />

            <SelectElement
                label="Approval Status"
                name="approval_status"
                :native="false"
                :items="approvalStatusOptions"
                size="sm"
                :default="defaultApprovalStatus"
                :conditions="[['role', 'in', ['3', '4']]]"
                :columns="6"
            />

            <!-- Conditionally render remarks field when status is rejected -->
            <TextareaElement
                :conditions="[
                    ['approval_status', 'in', ['suspended', 'pending']],
                ]"
                name="remarks"
                label="Rejection Remarks"
                rules="required"
                size="sm"
                :columns="12"
            />

            <GroupElement
                name="crednetials_information"
                label="Credentials information"
            >
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
                        regex: 'The Password must at least 8 characters long and contain at least one number, one uppercase and one lowercase character.',
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
    </CreateEditVueFormModal>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import CreateEditVueFormModal from "@/backend/components/modals/CreateEditVueFormModal.vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
    show: { type: Boolean, default: false },
    selectedResource: { type: Object, default: null },
});

const roles = usePage().props.dropdownData.roles.map((role) => ({
    value: role.id,
    label: role.name,
}));
const agencies = usePage().props.dropdownData.agencies.map((agency) => ({
    value: agency.id,
    label: agency.name,
}));

const defaultRoleId = computed(() => {
    const selectedRole = roles.find(
        (role) => role.label === props.selectedResource?.roles
    );
    return selectedRole ? selectedRole.value : "5"; // Default to ID 13 if not found
});
const defaultAgencyId = computed(() => {
    const selectedAgency = agencies.find(
        (agency) => agency.value === props.selectedResource?.agency_id
    );
    return selectedAgency ? selectedAgency.value : "5";
});

const approvalStatusOptions = [
    { value: "pending", label: "Pending" },
    { value: "active", label: "Approved" },
    { value: "suspended", label: "Rejected" },
];

const defaultApprovalStatus = computed(() => {
    return props.selectedResource?.approval_status || "pending";
});

// console.log(props.selectedResource.status_id);

const emit = defineEmits(["close", "save", "updated"]);
const errors = ref({});
const isEditMode = computed(() => !!props.selectedResource?.id);
const handleFormError = (serverErrors) => {
    errors.value = serverErrors;
};
</script>
