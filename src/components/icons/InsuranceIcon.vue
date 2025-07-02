<template>
    <svg width="87" height="87" viewBox="0 0 87 87" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="43.625" cy="43.1039" r="43.125" transform="rotate(-90 43.625 43.1039)" :fill="circleFill" />
        <path
            d="M54 33.7489L43.5 30.1688L33 33.7489V44.1825C33 46.6037 33.6242 48.9995 34.8125 51.1376C35.9093 53.1109 37.5006 54.7858 39.4043 56.0145L39.7891 56.2538L39.7939 56.2577L43.5 58.495L47.2061 56.2577L47.2109 56.2538C49.2704 55.0159 51.0158 53.213 52.1973 51.12C53.3709 49.0408 54 46.6142 54 44.1825V33.7489ZM56.9912 44.7333C56.9028 47.4847 56.1535 50.2147 54.8096 52.5956L54.5332 53.0673C53.1109 55.4051 51.1087 57.4114 48.7568 58.8251L43.5 61.9999L38.2432 58.8251C35.8911 57.4113 33.8891 55.4395 32.4668 53.0731L32.1904 52.5956C30.8464 50.1774 30.0971 47.4797 30.0088 44.7323L30 44.1825V31.6034L43.5 26.9999L57 31.6034V44.1825L56.9912 44.7333Z"
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