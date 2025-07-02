<template>
    <svg width="87" height="87" viewBox="0 0 87 87" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="43.125" cy="43.3328" r="43.125" :fill="circleFill" />
        <path
            d="M55 43.2078C55 36.5803 49.6274 31.2078 43 31.2078C36.3726 31.2078 31 36.5803 31 43.2078C31 49.8352 36.3726 55.2078 43 55.2078V58.2078C34.7157 58.2078 28 51.492 28 43.2078C28 34.9235 34.7157 28.2078 43 28.2078C51.2843 28.2078 58 34.9235 58 43.2078C58 51.492 51.2843 58.2078 43 58.2078V55.2078C49.6274 55.2078 55 49.8352 55 43.2078Z"
            :fill="pathFill" />
        <path d="M42 44.2078V41.2078H51V44.2078H42Z" :fill="pathFill" />
        <path d="M45 44.2078H42V35.2078H45V44.2078Z" :fill="pathFill" />
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