<template>
    <svg width="87" height="87" viewBox="0 0 87 87" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="43.625" cy="43.3328" r="43.125" :fill="circleFill" />
        <path
            d="M56.5 34.2078V59.2078H29.5V27.2078H50L56.5 34.2078ZM32.5 56.2078H53.5V35.3845L48.6924 30.2078H32.5V56.2078Z"
            :fill="pathFill" />
        <path d="M36 43.2078L36 40.2078L50 40.2078L50 43.2078L36 43.2078Z" :fill="pathFill" />
        <path d="M36 49.2078L36 46.2078L50 46.2078L50 49.2078L36 49.2078Z" :fill="pathFill" />
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