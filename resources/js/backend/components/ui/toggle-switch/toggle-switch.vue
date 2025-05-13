<template>
    <div class="flex items-center space-x-3">
        <label :for="id" class="text-gray-700">{{ label }}</label>
        <button :id="id" type="button" class='relative inline-flex h-5 w-10 transition-colors duration-200 ease-in-out rounded-full'
            :class="[ isOn ? 'bg-green-600' : 'bg-gray-400']" 
            @click="toggle">
            <span class="inline-block h-4 w-4 mt-0.5 ms-0.5  transform rounded-full bg-white transition duration-200 ease-in-out" :class="[ isOn ? 'translate-x-5' : 'translate-x-0' ]" />
        </button>
    </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue'

const props = defineProps({
    modelValue: {
        type: Boolean,
        default: false
    },
    label: {
        type: String,
        default: ''
    }
})

const emit = defineEmits(['update:modelValue'])

const isOn = ref(props.modelValue)

// Sync modelValue prop with local isOn ref
watch(
    () => props.modelValue,
    (newValue) => {
        isOn.value = newValue
    }
)

// Toggle the switch
const toggle = () => {
    isOn.value = !isOn.value
    emit('update:modelValue', isOn.value)
}

// Optional unique id for the switch label association
const id = computed(() => `toggle-switch-${Math.random().toString(36).substr(2, 9)}`)
</script>

<style scoped>
/* Add some custom styles if needed */
</style>