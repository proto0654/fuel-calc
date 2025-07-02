<template>
    <div class="bg-white py-6 flex flex-col justify-between min-h-[120px]">
        <div class="px-8 pt-8 pb-4 border border-gray-200 mb-[-6px] rounded">
            <label class="block text-sm text-gray-400 mb-1">Прокачка</label>
            <div class="text-2xl text-gray-900 mb-4">{{ value }} тонн</div>
        </div>
        <div class="flex flex-col justify-end flex-1">
            <input type="range" :min="min" :max="max" v-model="value"
                class="w-full accent-yellow-400 h-2 rounded-sm appearance-none bg-gray-200 focus:outline-none focus:ring-0 focus:shadow-none slider-thumb"
                @mouseup="handleMouseUp" @touchend="handleMouseUp" />
            <div class="flex justify-between text-xs text-gray-400 mt-2 relative">
                <span>{{ min }} тонн</span>
                <span class="absolute left-1/2 -translate-x-1/2 text-gray-400">{{ Math.floor((max - min) / 2 + min) }}
                    тонн</span>
                <span>{{ max }}+ тонн</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, defineProps, defineEmits } from 'vue'
const props = defineProps({
    min: { type: Number, default: 0 },
    max: { type: Number, default: 500 },
    modelValue: { type: Number, default: 0 }
})
const emit = defineEmits(['update:modelValue', 'release'])
const value = ref(props.modelValue)
watch(() => props.modelValue, v => value.value = v)

// Watch for changes in the max prop and adjust value if necessary
watch(() => props.max, (newMax) => {
    if (value.value > newMax) {
        value.value = newMax;
    }
});

watch(value, v => {
    emit('update:modelValue', Number(v))
})

const handleMouseUp = () => {
    emit('release', Number(value.value));
}
</script>

<style scoped>
/* Кастомизация ползунка для лучшего соответствия макету */
input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 20px;
    height: 20px;
    background: #fff;
    border: 5px solid #ffffff;
    border-radius: 50%;
    box-shadow:
        0 2px 3px 2px rgba(105, 105, 105, 0.1),


        0 0 0 7px #FBCE07 inset;
    cursor: pointer;

    margin-top: -7px;
    position: relative;
}

input[type="range"]::-webkit-slider-thumb:hover {
    border-width: 3px
}

input[type="range"]::-moz-range-thumb {
    width: 24px;
    height: 24px;
    background: #fff;
    border: none;
    border-radius: 50%;
    box-shadow:
        0 2px 8px rgba(251, 206, 7, 0.15),
        0 0 0 8px #fff,
        0 0 0 12px #FBCE07;
    cursor: pointer;
    transition: border 0.2s;
    margin-top: -9px;
    transform: translateY(-9px);
    position: relative;
}

input[type="range"]::-ms-thumb {
    width: 24px;
    height: 24px;
    background: #fff;
    border: none;
    border-radius: 50%;
    box-shadow:
        0 2px 8px rgba(251, 206, 7, 0.15),
        0 0 0 8px #fff,
        0 0 0 12px #FBCE07;
    cursor: pointer;
    transition: border 0.2s;
    margin-top: -9px;
    position: relative;
}

input[type="range"]::-webkit-slider-runnable-track {
    height: 6px;
    border-radius: 4px;
    background: linear-gradient(to right, #FBCE07 0%, #FBCE07 calc(var(--percent, 0%) + 0.1%), #E5E7EB calc(var(--percent, 0%) + 0.1%), #E5E7EB 100%);
}

input[type="range"]::-ms-fill-lower {
    background: #FBCE07;
}

input[type="range"]::-ms-fill-upper {
    background: #E5E7EB;
}

input[type="range"]:focus {
    outline: none;
}
</style>