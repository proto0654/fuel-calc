<template>
    <svg width="87" height="87" viewBox="0 0 87 87" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="43.375" cy="43.3328" r="43.125" transform="rotate(-90 43.375 43.3328)" :fill="circleFill" />
        <path
            d="M52.25 56.2078V59.2078H34.25V56.2078H52.25ZM56.25 52.2078V34.2078C56.25 31.9986 54.4591 30.2078 52.25 30.2078H34.25C32.0409 30.2078 30.25 31.9986 30.25 34.2078V52.2078C30.25 54.4169 32.0409 56.2078 34.25 56.2078V59.2078C30.384 59.2078 27.25 56.0738 27.25 52.2078V34.2078C27.25 30.3418 30.384 27.2078 34.25 27.2078H52.25C56.116 27.2078 59.25 30.3418 59.25 34.2078V52.2078C59.25 56.0738 56.116 59.2078 52.25 59.2078V56.2078C54.4591 56.2078 56.25 54.4169 56.25 52.2078Z"
            :fill="pathFill" />
        <path d="M41 51.2078H38L38 37.2078H41L41 51.2078Z" :fill="pathFill" />
        <path
            d="M46 43.2078V46.2078H41V43.2078H46ZM46 40.2078H41V46.2078L40.8457 46.2039C39.2606 46.1235 38 44.8129 38 43.2078V40.2078C38 38.5509 39.3431 37.2078 41 37.2078H46C47.6569 37.2078 49 38.5509 49 40.2078V43.2078C49 44.8646 47.6569 46.2078 46 46.2078V40.2078Z"
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