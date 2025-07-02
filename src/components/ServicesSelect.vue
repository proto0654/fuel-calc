<template>
    <div class="mb-6">
        <label class="block text-sm mb-2 font-medium">Дополнительные услуги</label>
        <div class="flex flex-wrap md:gap-3">
            <button v-for="service in services" :key="service.value" @click="toggleService(service)" :class="['flex flex-col items-center px-2 py-2 rounded-lg border-0 w-24',
                selected.includes(service.value) ? '' : 'border-transparent',
                selected.length >= 4 && !selected.includes(service.value) ? 'opacity-50 pointer-events-none' : '']">
                <div class="w-16 h-16 flex items-center justify-center rounded-full mb-1">
                    <BrandIcon :brand="service.icon" :active="selected.includes(service.value)" :isService="true"
                        :baseCircleColor="service.baseCircleColor" :activeCircleColor="service.activeCircleColor" />
                </div>
                <span class="text-xs text-center w-full block truncate"
                    :class="selected.includes(service.value) ? 'text-gray-900' : 'text-gray-400'">{{ service.label
                    }}</span>
            </button>
        </div>
        <div v-if="selected.length >= 4" class="text-sm text-red-500 mt-5">Можно выбрать не более 4 услуг</div>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch } from 'vue'
import BrandIcon from './icons/BrandIcon.vue'
const props = defineProps({
    modelValue: { type: Array, default: () => [] },
    services: { type: Array, default: () => [] }
})
const emit = defineEmits(['update:modelValue'])
const selected = ref(props.modelValue)
watch(() => props.modelValue, v => selected.value = v)
function toggleService(service) {
    if (selected.value.includes(service.value)) {
        selected.value = selected.value.filter(v => v !== service.value)
    } else if (selected.value.length < 4) {
        selected.value.push(service.value)
    }
    emit('update:modelValue', selected.value)
}
</script>