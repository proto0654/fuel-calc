<template>
    <div class="my-10 md:my-16">
        <div class="flex flex-col md:flex-row md:items-start gap-4 md:gap-8">
            <div class="mb-2 text-xl leading-7 text-gray-500 md:mb-0 md:mr-5">
                Ваша экономия:
            </div>
            <div class="flex flex-col md:flex-row gap-8 md:items-center">
                <div>
                    <div class="text-xs text-gray-400 uppercase">Экономия в год</div>
                    <div class="text-2xl font-bold">от&nbsp;{{ formatCurrency(yearlySavings) }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-400 uppercase">Экономия в месяц</div>
                    <div class="text-2xl font-bold">от&nbsp;{{ formatCurrency(monthlySavings) }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    monthlyCost: { type: Number, default: 0 },
    monthlySavings: { type: Number, default: 0 },
    yearlySavings: { type: Number, default: 0 },
})

const formatCurrency = (value) => {
    return new Intl.NumberFormat('ru-RU', { style: 'currency', currency: 'RUB', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(Math.floor(value))
}
</script>