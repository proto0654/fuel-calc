<template>
  <component :is="iconComponent" :circleFill="currentCircleFill" :pathFill="currentPathFill"
    :ellipseFill="currentEllipseFill" :whiteFill="currentWhiteFill" />
</template>

<script setup>
import { computed } from 'vue'

import FinesIcon from './FinesIcon.vue'
import WashIcon from './WashIcon.vue'
import SmsIcon from './SmsIcon.vue'
import DelayIcon from './DelayIcon.vue'
import InsuranceIcon from './InsuranceIcon.vue'
import PprpayIcon from './PprpayIcon.vue'
import ParkingIcon from './ParkingIcon.vue'
import TelematicsIcon from './TelematicsIcon.vue'
import EdoIcon from './EdoIcon.vue'
import RosneftIcon from './RosneftIcon.vue'
import TatneftIcon from './TatneftIcon.vue'
import LukoilIcon from './LukoilIcon.vue'
import BashneftIcon from './BashneftIcon.vue'
import GazpromIcon from './GazpromIcon.vue'
import ShellIcon from './ShellIcon.vue'
// ... если есть еще иконки, импортируйте их сюда

const icons = {
  FinesIcon,
  WashIcon,
  SmsIcon,
  DelayIcon,
  InsuranceIcon,
  PprpayIcon,
  ParkingIcon,
  TelematicsIcon,
  EdoIcon,
  RosneftIcon,
  TatneftIcon,
  LukoilIcon,
  BashneftIcon,
  GazpromIcon,
  ShellIcon,
  // ... добавьте остальные иконки
}

const props = defineProps({
  brand: {
    type: String,
    required: true
  },
  active: {
    type: Boolean,
    default: false
  },
  isService: {
    type: Boolean,
    default: false
  },
  baseCircleColor: {
    type: String,
    default: null
  },
  activeCircleColor: {
    type: String,
    default: '#FBCE07' // Default active color for circle if not overridden
  }
})

const iconComponent = computed(() => {
  if (!props.brand) return null
  const componentName = props.brand.charAt(0).toUpperCase() + props.brand.slice(1) + 'Icon'
  return icons[componentName] || null
})

const currentCircleFill = computed(() => {
  if (props.active) {
    if (props.isService && props.activeCircleColor) {
      return props.activeCircleColor // Unique active color for service circles
    }
    return '#FBCE07' // Yellow for active brand circles
  }
  // Inactive state
  if (props.isService && props.baseCircleColor) {
    return props.baseCircleColor // Custom inactive color for service circles
  }
  return '#F1F1F1' // Default inactive color for brand circles
})

const currentPathFill = computed(() => {
  let fill
  const brandLower = props.brand.toLowerCase()

  if (props.isService) {
    fill = props.active ? 'white' : '#D7D7D7' // Active service icons are white, inactive are default gray
  } else {
    // Logic for brand icons
    if (brandLower === 'rosneft') {
      fill = props.active ? '#DD1D21' : '#999999'
    } else if (brandLower === 'shell') {
      fill = props.active ? '#DD1D21' : '#D7D7D7'
    } else if (brandLower === 'gazprom') {
      fill = props.active ? '#DD1D21' : '#999999'
    } else if (brandLower === 'lukoil') {
      fill = props.active ? '#DD1D21' : '#999999'
    } else if (brandLower === 'bashneft') {
      fill = props.active ? '#DD1D21' : '#D7D7D7'
    } else if (brandLower === 'tatneft') {
      fill = props.active ? '#DD1D21' : '#999999'
    }
  }
  // Default fallback: if no specific fill is set, use red for active brands/inactive services, default gray for others
  return fill || (props.active && !props.isService ? '#DD1D21' : '#D7D7D7')
})

const currentEllipseFill = computed(() => {
  let fill
  const brandLower = props.brand.toLowerCase()

  if (brandLower === 'tatneft' || brandLower === 'wash') {
    // Ellipse acts as the main circle for Tatneft (brand) and Wash (service)
    if (props.active) {
      if (props.isService && props.activeCircleColor) {
        fill = props.activeCircleColor // Unique active color for service ellipse
      } else {
        fill = '#FBCE07' // Yellow for active brand ellipse
      }
    } else {
      // Inactive state
      if (props.isService && props.baseCircleColor) {
        fill = props.baseCircleColor // Custom inactive color for service ellipse
      } else {
        fill = '#F1F1F1' // Default inactive color for brand ellipse
      }
    }
  }
  return fill // Only Tatneft and Wash use ellipseFill as a main background
})

const currentWhiteFill = computed(() => {
  let fill
  const brandLower = props.brand.toLowerCase()
  if (brandLower === 'rosneft') {
    // Rosneft's white parts should follow the circle's active color
    fill = props.active ? '#FBCE07' : 'white'
  }
  return fill // Only Rosneft uses whiteFill
})
</script>