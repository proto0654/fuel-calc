<script setup>
import OrderForm from './OrderForm.vue'

const { isVisible, tariffName, regionName, fuelAmount, fuelType, brandName, selectedServices, promoName, monthlyCost, totalDiscountPercentage, monthlySavings, yearlySavings } = defineProps({
  isVisible: {
    type: Boolean,
    default: false
  },
  tariffName: {
    type: String,
    required: true
  },
  regionName: String,
  fuelAmount: Number,
  fuelType: String,
  brandName: String,
  selectedServices: Array,
  promoName: String,
  monthlyCost: Number,
  totalDiscountPercentage: Number,
  monthlySavings: Number,
  yearlySavings: Number
})

const emit = defineEmits(['close'])

const closeModal = () => {
  emit('close')
}
</script>

<template>
  <div v-if="isVisible" class="fixed inset-0 z-50 flex items-center justify-center">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-[rgba(44,222,222,0.85)] backdrop-blur-sm transition-all duration-300"
      @click="closeModal"></div>

    <!-- Modal Content -->
    <div class="bg-white p-10 rounded-lg shadow-2xl z-50 w-full max-w-[420px] mx-4 relative flex flex-col items-center"
      style="font-family: 'Proxima Nova', Arial, Helvetica, sans-serif;">
      <button @click="closeModal"
        class="absolute top-2 right-4 text-gray-400 hover:text-gray-700 !text-3xl leading-none focus:outline-none transition-all duration-200">&times;</button>
      <h2 class="text-gray-800 text-2xl md:text-3xl !font-semibold text-center mb-8 leading-tight">Заказать тариф<br>«{{
        tariffName
      }}»
      </h2>
      <!-- Modal Body - Form will go here -->
      <OrderForm :tariff-name="tariffName" :region-name="regionName" :fuel-amount="fuelAmount" :fuel-type="fuelType"
        :brand-name="brandName" :selected-services="selectedServices" :promo-name="promoName"
        :monthly-cost="monthlyCost" :total-discount-percentage="totalDiscountPercentage"
        :monthly-savings="monthlySavings" :yearly-savings="yearlySavings" />
    </div>
  </div>
</template>

<style scoped>
/* Add any specific styles here if needed, but Tailwind should cover most */
</style>