<template>
     <button class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md px-6 py-2">
        {{ label }}

        <span v-if="processing" class="animate-spin ml-2">        
            <svg class="w-5 h-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m0 14v1m8.486-9h-1M4.514 12H3.5M16.949 7.05l-.707.707M7.757 16.243l-.707.707M16.949 16.95l-.707-.707M7.757 7.757l-.707-.707"/>
            </svg>
        </span>
    </button>
</template>

<script setup>
defineProps({
    label: {
        type: String,
    },
    processing:{
        type: Boolean,
        default: false
    }
});

</script>

<style lang="scss" scoped>

</style>