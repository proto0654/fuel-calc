<template>
    <svg width="87" height="87" viewBox="0 0 87 87" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="43.375" cy="43.3328" r="43.125" :fill="circleFill" />
        <path
            d="M59.25 29.2078V57.2078H46L36 65.2078V57.2078H27.25V29.2078H59.25ZM39 58.9656L44.126 54.865L44.3311 54.7146C44.8232 54.3851 45.4039 54.2078 46 54.2078H56.25V32.2078H30.25V54.2078H36C37.6569 54.2078 39 55.5509 39 57.2078V58.9656Z"
            :fill="pathFill" />
    </svg>
</template>

<script setup>
import { defineProps } from 'vue'

defineProps({
    circleFill: {
        type: String,
        default: '#F1F1F1' // Default inactive color for circle
    },
    pathFill: {
        type: String,
        default: '#D7D7D7' // Default inactive color for path
    }
})
</script>