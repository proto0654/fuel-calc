<template>
    <div class="mb-6">
        <label class="block text-sm mb-2 font-medium">Укажите любимый бренд</label>
        <div class="flex md:gap-4">
            <button v-for="brandItem in availableBrands" :key="brandItem.value" @click="selectBrand(brandItem)" :class="['flex flex-col items-center px-2 py-2 rounded-lg border-0 w-24',
                modelValue === brandItem.value ? '' : 'border-transparent']">
                <div class="w-16 h-16 flex items-center justify-center rounded-full mb-1">
                    <BrandIcon :brand="brandItem.icon" :active="modelValue === brandItem.value" />
                </div>
                <span class="text-xs text-center w-full block truncate"
                    :class="modelValue === brandItem.value ? 'text-gray-900' : 'text-gray-400'">{{ brandItem.label
                    }}</span>
            </button>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits, watch } from 'vue'
import BrandIcon from './icons/BrandIcon.vue'
const props = defineProps({
    modelValue: { type: String, default: '' },
    availableBrands: { type: Array, default: () => [] }
})
const emit = defineEmits(['update:modelValue'])

// We no longer need the hardcoded 'brands' array here, as we receive it via props
// const brands = [
//     { label: 'Shell', value: 'shell' },
//     { label: 'Газпром', value: 'gazprom' },
//     { label: 'Роснефть', value: 'rosneft' },
//     { label: 'Татнефть', value: 'tatneft' },
//     { label: 'Лукойл', value: 'lukoil' },
//     { label: 'Башнефть', value: 'bashneft' },
// ]

// Initialize selected with modelValue or the first available brand if any
// Use a computed property for 'selected' if you want it to react to changes in availableBrands
let selected = props.modelValue || (props.availableBrands.length > 0 ? props.availableBrands[0].value : '')

watch(() => props.modelValue, v => {
    if (v) selected = v
})

// Also watch availableBrands to update selected if the current selected brand is no longer available
watch(() => props.availableBrands, (newBrands) => {
    if (!newBrands.some(b => b.value === selected) && newBrands.length > 0) {
        selected = newBrands[0].value;
        emit('update:modelValue', selected); // Emit update if selected brand changes
    }
});

function selectBrand(brandItem) {
    selected = brandItem.value
    emit('update:modelValue', brandItem.value)
}
</script>