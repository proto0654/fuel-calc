<template>
    <div class="my-6 pb-8">
        <div class="flex w-full">
            <button v-for="type in fuelTypes" :key="type.value" @click="selectType(type)" :class="[
                'flex-1 px-4 py-2 -mb-px font-medium text-center',
                modelValue === type.value ? 'border-b-4 border-cyan-400 text-black' : 'border-b-4 border-gray-200 text-gray-400'
            ]">
                {{ type.label }}
            </button>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue'

const { modelValue, fuelTypes } = defineProps({
    modelValue: { type: String, default: 'petrol' },
    fuelTypes: { type: Array, default: () => [] }
})
const emit = defineEmits(['update:modelValue'])

function selectType(type) {
    emit('update:modelValue', type.value)
}
</script>