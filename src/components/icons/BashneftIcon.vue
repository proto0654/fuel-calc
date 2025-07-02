<template>
  <svg width="87" height="87" viewBox="0 0 87 87" fill="none" xmlns="http://www.w3.org/2000/svg">
    <g clip-path="url(#clip0_30_42)">
      <circle cx="43.375" cy="43.3328" r="43.125" :fill="circleFill" />
      <path d="M43.2354 47.2664V58.8064L63.1064 42.8298L63.1436 42.655L63.4062 41.3962C63.4671 42.0336 63.5 42.6795 63.5 43.3328C63.5 54.4475 54.4897 63.4578 43.375 63.4578C32.2603 63.4578 23.25 54.4475 23.25 43.3328C23.25 39.6072 24.2628 36.1183 26.0273 33.1257L43.2354 47.2664Z" :fill="pathFill" />
      <path d="M43.375 23.2078C50.637 23.2078 56.9999 27.0545 60.5391 32.821L43.6211 46.4539V35.531L32.5156 26.3855C35.6483 24.374 39.3756 23.2078 43.375 23.2078Z" :fill="pathFill" />
    </g>
    <defs>
      <clipPath id="clip0_30_42">
        <rect width="86.25" height="86.25" fill="white" transform="translate(0.25 0.207764)" />
      </clipPath>
    </defs>
  </svg>
</template>

<script setup>
import { defineProps } from 'vue'

const props = defineProps({
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