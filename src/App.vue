<script setup>
import { ref } from 'vue'
import { useCalculator } from './composables/useCalculator.js'
import RegionSelect from './components/RegionSelect.vue'
import SliderInput from './components/SliderInput.vue'
import FuelTypeTabs from './components/FuelTypeTabs.vue'
import BrandSelect from './components/BrandSelect.vue'
import ServicesSelect from './components/ServicesSelect.vue'
import TariffCard from './components/TariffCard.vue'
import PromoActions from './components/PromoActions.vue'
import CalculationResult from './components/CalculationResult.vue'
import OrderButton from './components/OrderButton.vue'
import OrderModal from './components/OrderModal.vue'

const {
  region,
  amount,
  fuelType,
  brand,
  services,
  promo,
  availableBrands,
  availablePromos,
  calculation,
  fuelTypes,
  regions,
  availableServices,
  triggerCalculation,
} = useCalculator()

const isOrderModalVisible = ref(false)

const openOrderModal = () => {
  isOrderModalVisible.value = true
}

const closeOrderModal = () => {
  isOrderModalVisible.value = false
}
</script>

<template>
  <main
    class="flex flex-col md:flex-row md:items-stretch md:p-14 md:gap-14 max-w-[1400px] mx-auto w-full my-10 md:my-0">
    <div class="w-full md:w-1/2 px-6 md:px-10 py-15">
      <h1 class="text-2xl font-bold mb-8">Калькулятор тарифов</h1>
      <RegionSelect v-model="region" :regions="regions" />
      <SliderInput v-model="amount" :min="0" :max="region.max" @release="triggerCalculation" />
      <FuelTypeTabs v-model="fuelType" :fuel-types="fuelTypes" />
      <BrandSelect v-model="brand" :availableBrands="availableBrands" />
      <ServicesSelect v-model="services" :services="availableServices" />
    </div>
    <div
      class="w-full md:w-1/2 rounded-2xl shadow-2xl/30 shadow-gray-400 px-6 md:px-10 pb-10 md:py-15 bg-white bg-gray-50">
      <TariffCard :tariff-name="calculation.tariffName" />
      <hr class="border-gray-200">
      <PromoActions v-model="promo" :available-promos="availablePromos" />
      <hr class="border-gray-200">
      <CalculationResult :monthly-cost="calculation.monthlyCost" :monthly-savings="calculation.monthlySavings"
        :yearly-savings="calculation.yearlySavings" />
      <OrderButton :tariff-name="calculation.tariffName" @click="openOrderModal" />
    </div>
  </main>

  <OrderModal :is-visible="isOrderModalVisible" :tariff-name="calculation.tariffName" :region-name="region?.label"
    :fuel-amount="amount" :fuel-type="fuelType" :brand-name="brand" :selected-services="services"
    :promo-name="promo?.label" :monthly-cost="calculation.monthlyCost"
    :total-discount-percentage="calculation.totalDiscountPercentage" :monthly-savings="calculation.monthlySavings"
    :yearly-savings="calculation.yearlySavings" @close="closeOrderModal">
    <!-- Form content is now passed through OrderModal to OrderForm -->
  </OrderModal>
</template>

<style scoped></style>
