<template>
  <svg width="87" height="87" viewBox="0 0 87 87" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle cx="43.625" cy="43.3328" r="43.125" :fill="circleFill" />
    <path fill-rule="evenodd" clip-rule="evenodd" d="M29.25 34.5702H32.9563V47.1384L29.25 43.8678V34.5702Z"
      :fill="pathFill" />
    <path fill-rule="evenodd" clip-rule="evenodd" d="M33.6836 30.4307H37.2426V51.2075L33.6836 47.7887V30.4307Z"
      :fill="pathFill" />
    <path fill-rule="evenodd" clip-rule="evenodd" d="M37.9697 26.2905H41.6021V45.9754H37.9697V26.2905Z"
      :fill="pathFill" />
    <path fill-rule="evenodd" clip-rule="evenodd" d="M42.3262 22.1497H46.1038V41.9074H42.3262V22.1497Z"
      :fill="pathFill" />
    <path fill-rule="evenodd" clip-rule="evenodd" d="M46.6127 26.0701H50.2461V45.975H46.6127V26.0701Z"
      :fill="pathFill" />
    <path fill-rule="evenodd" clip-rule="evenodd" d="M51.118 30.3539H54.6771V47.7164L51.118 51.2071V30.3539Z"
      :fill="pathFill" />
    <path fill-rule="evenodd" clip-rule="evenodd" d="M55.3289 34.4972H58.9642V43.5787L55.3289 47.1388V34.4972Z"
      :fill="pathFill" />
    <path fill-rule="evenodd" clip-rule="evenodd" d="M37.9697 46.4141H41.6021V64.6411H37.9697V46.4141Z" fill="white" />
    <path fill-rule="evenodd" clip-rule="evenodd" d="M42.3262 42.4919H45.8842V64.6418H42.3262V42.4919Z" fill="white" />
    <path fill-rule="evenodd" clip-rule="evenodd" d="M46.6127 46.4836H50.2461V64.6413H46.6127V46.4836Z" fill="white" />
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
    default: '#999999' // Default inactive color for paths
  },
  whiteFill: {
    type: String,
    default: 'white' // Default inactive color for paths with fill="white"
  }
})
</script>