<template>
    <svg width="87" height="87" viewBox="0 0 87 87" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="43.125" cy="43.3328" r="43.125" :fill="circleFill" />
        <path
            d="M51 47.2078C51 43.3418 47.866 40.2078 44 40.2078H42C38.134 40.2078 35 43.3418 35 47.2078V55.2078H51V47.2078ZM54 58.2078H32V47.2078C32 41.6849 36.4772 37.2078 42 37.2078H44C49.5228 37.2078 54 41.6849 54 47.2078V58.2078Z"
            :fill="pathFill" />
        <path d="M30.0605 35.8035L27.9395 37.9246L23.9395 33.9246L26.0605 31.8035L30.0605 35.8035Z" :fill="pathFill" />
        <path d="M55.9395 35.8035L58.0605 37.9246L62.0605 33.9246L59.9395 31.8035L55.9395 35.8035Z" :fill="pathFill" />
        <path d="M41.5002 30.8646H44.4998V25.2078H41.5002V30.8646Z" :fill="pathFill" />
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