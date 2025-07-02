<template>
  <svg width="87" height="86" viewBox="0 0 87 86" fill="none" xmlns="http://www.w3.org/2000/svg">
    <ellipse cx="42.4511" cy="43.125" rx="42.4511" ry="43.125"
      transform="matrix(-5.24385e-08 -1 -1 5.08126e-08 87 85.4469)" :fill="ellipseFill" />
    <path
      d="M36.0674 28.2372C32.7279 36.5819 38.1729 41.9381 43.5967 47.3031C48.6445 52.7845 53.0909 58.4824 44.1479 68.7366C47.4886 60.393 42.0424 55.0357 36.6231 49.6762C31.5708 44.1827 27.1244 38.4925 36.0674 28.2372Z"
      :fill="pathFill" />
    <path
      d="M44.0021 17.5033C40.6565 25.8511 46.1 31.2038 51.5291 36.5654C56.5765 42.0511 61.0224 47.7488 52.0748 58.0027C55.4181 49.6528 49.9724 44.3012 44.5489 38.9396C39.4981 33.4528 35.0567 27.7573 44.0021 17.5033Z"
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
    default: '#999999' // Default inactive color for paths
  }
})
</script>