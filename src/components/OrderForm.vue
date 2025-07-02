<script setup>
import { ref, watch } from 'vue'
import CheckmarkIcon from './icons/CheckmarkIcon.vue'

const { tariffName, regionName, fuelAmount, fuelType, brandName, selectedServices, promoName, monthlyCost, totalDiscountPercentage, monthlySavings, yearlySavings } = defineProps({
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

const inn = ref('')
const phone = ref('')
const email = ref('')
const agreeToProcessing = ref(false)

const innError = ref('')
const phoneError = ref('')
const emailError = ref('')
const agreeError = ref('')

const submissionMessage = ref('')
const submissionMessageType = ref('') // 'success' or 'error'

const formSubmitted = ref(false)
const isPristine = ref(true)

const validateInn = () => {
  if (inn.value.length === 0) {
    innError.value = 'ИНН обязателен.'
  } else if (!/^[0-9]{12}$/.test(inn.value)) {
    innError.value = 'ИНН должен состоять ровно из 12 цифр.'
  } else {
    innError.value = ''
  }
}

const validatePhone = () => {
  const cleanedPhone = phone.value.replace(/[-\s()]/g, ''); // Remove spaces, hyphens, and parentheses
  if (cleanedPhone.length === 0) {
    phoneError.value = 'Телефон обязателен.';
  } else if (!/^\+?[0-9]{11}$/.test(cleanedPhone)) {
    phoneError.value = 'Телефон должен содержать ровно 11 цифр (возможно с + в начале), игнорируя пробелы, дефисы и скобки.';
  } else {
    phoneError.value = '';
  }
}

const validateEmail = () => {
  if (email.value.length === 0) {
    emailError.value = 'Email обязателен.'
  } else if (!/^[\w-.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email.value)) {
    emailError.value = 'Введите корректный email адрес.'
  } else {
    emailError.value = ''
  }
}

const validateAgree = () => {
  if (!agreeToProcessing.value) {
    agreeError.value = 'Необходимо согласиться на обработку персональных данных.'
  } else {
    agreeError.value = ''
  }
}

watch(inn, validateInn)
watch(phone, validatePhone)
watch(email, validateEmail)
watch(agreeToProcessing, validateAgree)

const isValidForm = () => {
  validateInn()
  validatePhone()
  validateEmail()
  validateAgree()

  return !innError.value && !phoneError.value && !emailError.value && !agreeError.value
}

const resetForm = () => {
  inn.value = ''
  phone.value = ''
  email.value = ''
  agreeToProcessing.value = false
  innError.value = ''
  phoneError.value = ''
  emailError.value = ''
  agreeError.value = ''
  formSubmitted.value = true
  isPristine.value = true
}

const handleSubmit = async () => {
  submissionMessage.value = '' // Clear previous messages
  submissionMessageType.value = ''

  // Set isPristine to false when form is submitted, so errors can show if invalid
  isPristine.value = false;

  if (isValidForm()) {
    const cleanedPhoneForSubmission = phone.value.replace(/[-\s()]/g, '');
    const formData = {
      action: 'submit_form',
      inn: inn.value,
      phone: cleanedPhoneForSubmission,
      email: email.value,
      agreeToTerms: agreeToProcessing.value,
      tariff: tariffName,
      region: regionName,
      amount: fuelAmount,
      fuelType: fuelType,
      brand: brandName,
      services: selectedServices,
      promoAction: promoName,
      monthlyCost: monthlyCost,
      totalDiscountPercentage: totalDiscountPercentage,
      monthlySavings: monthlySavings,
      yearlySavings: yearlySavings
    }

    try {
      const response = await fetch('/backend/api.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
      })

      // Process the JSON response from the backend
      const data = await response.json();

      if (data.status === 'error') {
        submissionMessage.value = `Ошибка: ${data.message}`
        submissionMessageType.value = 'error'
      } else if (data.status === 'success') {
        submissionMessage.value = 'Спасибо! Успешно отправлено.'
        submissionMessageType.value = 'success'
        resetForm()
      } else {
        // Fallback for unexpected successful responses without a redirect URL
        submissionMessage.value = 'Спасибо! Успешно отправлено (неожиданный ответ).'
        submissionMessageType.value = 'success'
        resetForm()
      }

    } catch (error) {
      submissionMessage.value = 'Ошибка: Не удалось отправить данные. Пожалуйста, попробуйте еще раз.'
      submissionMessageType.value = 'error'
      console.error('Error submitting form:', error)
    }
  } else {
    submissionMessage.value = 'Ошибка: Пожалуйста, исправьте ошибки в форме.'
    submissionMessageType.value = 'error'
  }
}
</script>

<template>
  <form @submit.prevent="handleSubmit" class="flex flex-col gap-4">
    <div>
      <input type="text" id="inn" v-model="inn" @blur="validateInn" @input="isPristine = false"
        class="block bg-gray-100 w-full border border-gray-200 rounded p-4 focus:ring-2 focus:ring-[#00CFCC] focus:border-[#00CFCC] placeholder-gray-600 text-base transition-all duration-200"
        maxlength="12" placeholder="Номер ИНН" />
      <p v-if="innError && !isPristine" class="text-red-500 text-xs mt-1">{{ innError }}</p>
    </div>
    <div>
      <input type="text" id="phone" v-model="phone" @blur="validatePhone" @input="isPristine = false"
        class=" block bg-gray-100 w-full border border-gray-200 rounded p-4 focus:ring-2 focus:ring-[#00CFCC] focus:border-[#00CFCC] placeholder-gray-600 text-base transition-all duration-200"
        maxlength="20" placeholder="Телефон для связи" />
      <p v-if="phoneError && !isPristine" class="text-red-500 text-xs mt-1">{{ phoneError }}</p>
    </div>
    <div>
      <input type="email" id="email" v-model="email" @blur="validateEmail" @input="isPristine = false"
        class=" bg-gray-100 block w-full border border-gray-200 rounded p-4 focus:ring-2 focus:ring-[#00CFCC] focus:border-[#00CFCC] placeholder-gray-600 text-base transition-all duration-200"
        placeholder="E-mail для связи" />
      <p v-if="emailError && !isPristine" class="text-red-500 text-xs mt-1">{{ emailError }}</p>
    </div>
    <div class="flex items-center gap-3 mb-2">
      <label class="relative flex items-center cursor-pointer select-none">
        <input type="checkbox" v-model="agreeToProcessing" @change="validateAgree" @input="isPristine = false"
          class="sr-only peer">
        <span
          class="w-6 h-6 rounded-full border-2 border-[#00CFCC] flex items-center justify-center bg-white peer-checked:bg-[#00CFCC] transition-all duration-200">
          <CheckmarkIcon v-if="agreeToProcessing" class="w-6 h-6" />
        </span>
      </label>
      <span class="text-sm text-gray-900">Согласен с обработкой персональных данных</span>
    </div>
    <p v-if="agreeError && !isPristine" class="text-red-500 text-xs -mt-2 mb-2">{{ agreeError }}</p>
    <button type="submit"
      class="w-full bg-[#FBCE07] hover:bg-yellow-400 py-4 rounded-md shadow-[0_8px_24px_#FBCE07]/30 transition font-bold text-base mt-2 mb-1 flex items-center justify-center gap-2 text-gray-700 tracking-wide"
      style="font-family: 'Proxima Nova', Arial, Helvetica, sans-serif;">
      Заказать тариф «{{ tariffName }}»
    </button>
    <p v-if="submissionMessage" :class="{
      'text-green-600': submissionMessageType === 'success',
      'text-red-500': submissionMessageType === 'error'
    }" class="mt-2 text-center font-medium">
      {{ submissionMessage }}
    </p>
  </form>
</template>

<style scoped>
/* Add any specific styles here if needed */
</style>