<template>
    <svg width="87" height="87" viewBox="0 0 87 87" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="43.375" cy="43.3328" r="43.125" :fill="circleFill" />
        <path
            d="M58.25 37.2078C58.25 34.4463 56.0114 32.2078 53.25 32.2078C50.4886 32.2078 48.25 34.4463 48.25 37.2078C48.25 39.9692 50.4886 42.2078 53.25 42.2078V45.2078C48.8317 45.2078 45.25 41.626 45.25 37.2078C45.25 32.7895 48.8317 29.2078 53.25 29.2078C57.6683 29.2078 61.25 32.7895 61.25 37.2078C61.25 41.626 57.6683 45.2078 53.25 45.2078V42.2078C56.0114 42.2078 58.25 39.9692 58.25 37.2078Z"
            :fill="pathFill" />
        <path d="M37.9856 58.339L57.4758 40.1122L59.5241 42.3031L40.0346 60.5307L37.9856 58.339Z" :fill="pathFill" />
        <path d="M27.8913 40.0025L26.9997 37.138L52.4777 29.2078L53.3693 32.0723L27.8913 40.0025Z" :fill="pathFill" />
        <path d="M35.7269 49.0195L34.2731 46.3952L47.2585 39.203L48.7122 41.8273L35.7269 49.0195Z" :fill="pathFill" />
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