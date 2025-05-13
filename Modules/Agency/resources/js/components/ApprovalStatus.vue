<!-- BasicInfo.vue -->
<template>
    <SelectElement
        label="Approval Status"
        name="status"
        :native="false"
        :items="approvalStatusOptions"
        size="sm"
        :default="defaultApprovalStatus"
    />
    <TextareaElement
        :conditions="[['approval_status', 'in', ['suspended', 'pending']]]"
        name="remarks"
        label="Rejection Remarks"
        rules="required"
        size="sm"
    />
</template>

<script setup>
import { ref, computed, watch } from "vue";
const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
});
const approvalStatusOptions = [
    { value: "pending", label: "Pending" },
    { value: "active", label: "Approved" },
    { value: "suspended", label: "Rejected" },
];
const defaultApprovalStatus = computed(() => {
    return props.data?.approval_status || "pending";
});

const emit = defineEmits(["update"]);
</script>
