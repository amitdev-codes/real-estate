<template>
    <div class="inspection-scheduling-form">
        <form @submit.prevent="scheduleInspection">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label>Preferred Date</label>
                    <input
                        type="date"
                        v-model="form.preferred_date"
                        required
                    />
                </div>
                <div>
                    <label>Preferred Time</label>
                    <input
                        type="time"
                        v-model="form.preferred_time"
                        required
                    />
                </div>
                <div>
                    <label>Number of Visitors</label>
                    <input
                        type="number"
                        v-model="form.visitors_count"
                        min="1"
                        max="5"
                    />
                </div>
            </div>

            <div class="mt-4">
                <label>Additional Requirements</label>
                <div class="flex space-x-4">
                    <label
                        v-for="req in inspectionRequirements"
                        :key="req.value"
                    >
                        <input
                            type="checkbox"
                            v-model="form.additional_requirements"
                            :value="req.value"
                        />
                        {{ req.label }}
                    </label>
                </div>
            </div>

            <div class="mt-4">
                <label>Special Instructions</label>
                <textarea
                    v-model="form.special_instructions"
                ></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Schedule Inspection
            </button>
        </form>
    </div>
    </template>

    <script setup>
    import { ref } from 'vue'
    import { useForm } from '@inertiajs/vue3'

    const props = defineProps({
        property: Object
    })

    const form = useForm({
        property_id: props.property.id,
        preferred_date: '',
        preferred_time: '',
        visitors_count: 1,
        additional_requirements: [],
        special_instructions: ''
    })

    const inspectionRequirements = [
        { value: 'agent_present', label: 'Agent Presence Required' },
        { value: 'virtual_tour', label: 'Virtual Tour Option' },
        { value: 'detailed_walkthrough', label: 'Detailed Walkthrough' }
    ]

    const scheduleInspection = () => {
        form.post(route('property.inspection.schedule'))
    }
    </script>
