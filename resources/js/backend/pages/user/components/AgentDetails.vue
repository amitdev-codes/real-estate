<template>
    <div
        class="grid grid-cols-1 md:grid-cols-2 gap-4"
    >
        <TextElement
            name="related_data.agent.id"
            label="Agent ID"
            :disabled="true"
            :default="props.data.related_data.agent?.id"
            class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
        />
        <TextElement
            name="related_data.agent.user_id"
            label="User ID"
            :disabled="true"
            :default="props.data.related_data.agent?.user_id"
            class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
        />
        <TextElement
            name="related_data.agent.agency_id"
            label="Agency ID"
            :disabled="true"
            :default="props.data.related_data.agent?.agency_id"
            class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
        />
    </div>
</template>

<script setup>
const props = defineProps({
  data: {
    type: Object,
    default: () => ({}),
  },
});




const emit = defineEmits(["update"]);
</script>