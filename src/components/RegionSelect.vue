<template>
    <div class="mb-6 rounded border border-gray-200 px-4 py-8" ref="rootRef">
        <label class="block text-sm mb-2 font-medium text-gray-700 px-4">Укажите регион передвижения</label>
        <div class="relative">
            <button @click="open = !open" type="button"
                :class="[open ? 'ring-2 ring-yellow-400 border-yellow-400' : 'border-gray-300']"
                class="w-full px-4 py-3 text-left flex justify-between items-center transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-yellow-200 focus:border-yellow-400">
                <span>{{ selectedRegion.label }}</span>
                <svg class="w-5 h-5 ml-2 text-gray-400 transform transition-transform duration-200"
                    :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <ul v-if="open"
                class="absolute z-10 w-full bg-white border border-gray-200 rounded-lg mt-1 shadow-xl max-h-60 overflow-auto !pl-0">
                <li v-for="regionOption in regions" :key="regionOption.value" @click="selectRegion(regionOption)"
                    class="px-4 py-3 text-gray-800 hover:bg-gray-100 hover:text-black cursor-pointer transition-colors duration-150 ease-in-out"
                    :class="{ 'bg-yellow-100 font-bold': regionOption.value === selectedRegion.value }">
                    {{ regionOption.label }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits, watch, onMounted, onUnmounted } from 'vue'

const props = defineProps({
    modelValue: { type: Object, default: () => ({ label: '', value: '', max: 0 }) },
    regions: { type: Array, default: () => [] }
})
const emit = defineEmits(['update:modelValue'])

const open = ref(false)
const selectedRegion = ref(props.modelValue || { label: '', value: '', max: 0 })

const rootRef = ref(null)

watch(() => props.modelValue, v => { if (v) selectedRegion.value = v })

// Watch for changes in the `regions` prop and update `selectedRegion` if needed
watch(() => props.regions, (newRegions) => {
    if (newRegions.length > 0 && !newRegions.some(r => r.value === selectedRegion.value.value)) {
        // If current selected region is not in new list, or no region is selected, default to the first one
        selectedRegion.value = newRegions[0];
        emit('update:modelValue', newRegions[0]);
    }
}, { immediate: true });

function selectRegion(newRegion) {
    selectedRegion.value = newRegion
    open.value = false
    emit('update:modelValue', newRegion)
}

function handleClickOutside(event) {
    if (open.value && rootRef.value && !rootRef.value.contains(event.target)) {
        open.value = false
    }
}

onMounted(() => {
    document.addEventListener('mousedown', handleClickOutside)
})
onUnmounted(() => {
    document.removeEventListener('mousedown', handleClickOutside)
})
</script>