<!-- components/StepperFormModal.vue -->
<template>
        <Vueform
            v-bind="vueformOptions"
            :model-value="modelValue"
            :endpoint="submitHandler"
            size="lg"
           
        >
            <template #empty>
                <div class="bg-white rounded-lg p-6 w-full max-w-7xl mx-auto shadow-box-circle dark:bg-dark-1000 relative">
                    <!-- Header with Title and Close Button -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">{{ title }}</h2>
                    </div>

                    <!-- Stepper Content -->
                    <FormSteps v-if="steps.length">
                        <FormStep
                            v-for="(step, index) in steps"
                            :key="index"
                            :name="step.name"
                            :elements="step.elements"
                        >
                            {{ step.label }}
                        </FormStep>
                    </FormSteps>

                    <!-- Form Elements -->
                    <FormElements>
                        <slot></slot> <!-- Custom form elements passed via slot -->
                    </FormElements>

                    <!-- Stepper Controls -->
                    <FormStepsControls />
                </div>
            </template>
        </Vueform>
</template>

<script setup>
import { defineProps, defineEmits } from "vue";

defineProps({
    show: { type: Boolean, required: true }, // Control visibility from parent
    title: { type: String, required: true },
    steps: { type: Array, required: true }, // Array of { name, label, elements }
    modelValue: { type: Object, default: () => ({}) },
    vueformOptions: { type: Object, default: () => ({}) },
    submitHandler: { type: Function, required: true },
    width: { type: Number, default: 60 },
});

defineEmits(["close"]);
</script>

<style scoped>
.shadow-box-circle {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
</style>