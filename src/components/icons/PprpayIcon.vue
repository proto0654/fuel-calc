<template>
    <svg width="87" height="87" viewBox="0 0 87 87" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="43.125" cy="43.3328" r="43.125" transform="rotate(-90 43.125 43.3328)" :fill="circleFill" />
        <path d="M30 55.2078L27 55.2078L27 31.2078L30 31.2078L30 55.2078Z" :fill="pathFill" />
        <path d="M54 55.2078L51 55.2078L51 31.2078L54 31.2078L54 55.2078Z" :fill="pathFill" />
        <path d="M60 55.2078L57 55.2078L57 31.2078L60 31.2078L60 55.2078Z" :fill="pathFill" />
        <path d="M36 50.2078L33 50.2078L33 31.2078L36 31.2078L36 50.2078Z" :fill="pathFill" />
        <path d="M48 50.2078L45 50.2078L45 31.2078L48 31.2078L48 50.2078Z" :fill="pathFill" />
        <path d="M42 50.2078L39 50.2078L39 31.2078L42 31.2078L42 50.2078Z" :fill="pathFill" />
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