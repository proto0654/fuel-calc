<template>
    <svg width="87" height="86" viewBox="0 0 87 86" fill="none" xmlns="http://www.w3.org/2000/svg">
        <ellipse cx="42.4511" cy="43.125" rx="42.4511" ry="43.125"
            transform="matrix(-5.24385e-08 -1 -1 5.08126e-08 87 85.3273)" :fill="ellipseFill" />
        <path
            d="M44 60.3274C51.7319 60.3274 57.9998 53.9182 58 46.012C58 34.3804 44 26.3274 44 26.3274L43.3984 26.6965C40.7184 28.3971 30 35.8346 30 46.012L33 46.012C33 41.4002 35.8089 37.2101 39.1113 33.9387C40.7182 32.3469 42.3366 31.0792 43.5557 30.2092C43.7102 30.0989 43.86 29.9983 44 29.9016C44.14 29.9983 44.2898 30.0989 44.4443 30.2092C45.6634 31.0792 47.2818 32.3469 48.8887 33.9387C52.1911 37.2101 55 41.4002 55 46.012C54.9998 52.3248 50.0123 57.3274 44 57.3274C37.9877 57.3274 33.0002 52.3248 33 46.012L30 46.012L30.0049 46.3811C30.1935 53.9939 36.1938 60.1296 43.6387 60.3225L44 60.3274Z"
            :fill="pathFill" />
    </svg>
</template>

<script setup>
import { defineProps } from 'vue'

defineProps({
    ellipseFill: {
        type: String,
        default: '#F1F1F1' // Default inactive color for ellipse
    },
    pathFill: {
        type: String,
        default: '#D7D7D7' // Default inactive color for path
    }
})
</script>