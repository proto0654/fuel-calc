<template>
    <div class="my-16">
        <label class="block text-lg mb-2 font-medium text-center mb-7">Выберите промо-акцию:</label>
        <div class="flex gap-3 md:gap-7 justify-center">
            <button v-for="p in availablePromos" :key="p.value" @click="selectPromo(p)"
                :class="['flex flex-col items-center relative w-24']">
                <div :class="['flex items-center justify-center w-16 h-16 md:w-24 md:h-24 rounded-full',
                    modelValue?.value === p.value ? 'bg-yellow-400' : 'bg-gray-100']">
                    <span
                        :class="['text-lg font-bold', modelValue?.value === p.value ? 'text-gray-900' : 'text-gray-500']">{{
                            p.label }}</span>
                </div>
                <span class="mt-2 text-xs text-center w-full block whitespace-pre-line break-words"
                    :class="modelValue?.value === p.value ? 'text-gray-900' : 'text-gray-400'">{{ p.desc }}</span>
                <CheckmarkIcon v-if="modelValue?.value === p.value" class="absolute top-0 right-0 w-7 h-7" />
            </button>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue'
import CheckmarkIcon from '@/components/icons/CheckmarkIcon.vue'

defineProps({
    modelValue: { type: Object, default: () => ({ label: '', value: 0, desc: '' }) },
    availablePromos: { type: Array, default: () => [] }
})
const emit = defineEmits(['update:modelValue'])
function selectPromo(promo) {
    emit('update:modelValue', promo)
}
</script>