import { ref, watch, onMounted, computed } from 'vue'

export function useCalculator() {
  const config = ref(null) // Reactive variable to store fetched configuration

  const region = ref({ label: 'Ленинградская область', value: 'region1', max: 1200 })
  const amount = ref(200)
  const fuelType = ref('benzene')
  const brand = ref('rosneft')
  const services = ref([])
  const promo = ref({ label: '', value: 0, desc: '' })

  // Client-side function to determine tariff, mirroring backend logic
  const getTariffClient = (fuelType, amount) => {
    switch (fuelType) {
      case 'benzene':
        if (amount < 100) return 'economy'
        if (amount >= 100 && amount <= 300) return 'favorite'
        if (amount > 300) return 'premium'
        break
      case 'gas':
        if (amount < 200) return 'economy'
        if (amount >= 200 && amount <= 700) return 'favorite'
        if (amount > 700) return 'premium'
        break
      case 'diesel':
        if (amount < 150) return 'economy'
        if (amount >= 150 && amount <= 350) return 'favorite'
        if (amount > 350) return 'premium'
        break
      default:
        return null
    }
  }

  // Новый computed для списка регионов
  const regions = computed(() => {
    if (!config.value || !config.value.regionMaxFuel) return []
    return Object.entries(config.value.regionMaxFuel).map(([value, max]) => {
      let label = ''
      if (value === 'region1') label = 'Ленинградская область'
      else if (value === 'region2') label = 'Московская область'
      else if (value === 'region3') label = 'Краснодарский край'
      else label = value
      return { label, value, max }
    })
  })

  // Новый computed для списка типов топлива
  const fuelTypes = computed(() => {
    if (!config.value || !config.value.fuelPrices) return []
    const fuelTypeMap = {
      benzene: 'Бензин',
      gas: 'Газ',
      diesel: 'ДТ',
    }
    return Object.keys(config.value.fuelPrices).map((key) => ({
      label: fuelTypeMap[key] || key.charAt(0).toUpperCase() + key.slice(1),
      value: key,
    }))
  })

  // New reactive state for calculation results from backend
  const calculation = ref({
    monthlyCost: 0,
    monthlySavings: 0,
    yearlySavings: 0,
    tariffName: '',
    totalDiscountPercentage: 0,
  })

  // Mapping for tariff names
  const tariffNameMap = {
    economy: 'Эконом',
    favorite: 'Избранный',
    premium: 'Премиум',
  }

  const availablePromos = computed(() => {
    if (!config.value || !config.value.allPromos || !config.value.promoActions) return []

    const currentTariff = getTariffClient(fuelType.value, amount.value)
    let allowedPromoValues = new Set()

    if (currentTariff) {
      if (config.value.promoActions.economy) {
        config.value.promoActions.economy.forEach((p) => allowedPromoValues.add(p))
      }
      if (currentTariff === 'favorite' || currentTariff === 'premium') {
        if (config.value.promoActions.favorite) {
          config.value.promoActions.favorite.forEach((p) => allowedPromoValues.add(p))
        }
      }
      if (currentTariff === 'premium') {
        if (config.value.promoActions.premium) {
          config.value.promoActions.premium.forEach((p) => allowedPromoValues.add(p))
        }
      }
    }

    const filteredPromos = config.value.allPromos.filter((p) => allowedPromoValues.has(p.value))

    // Always sort the displayed promos by value (highest first)
    return filteredPromos.sort((a, b) => b.value - a.value)
  })

  // Mapping for fuel brand names
  const brandNameMap = {
    rosneft: 'Роснефть',
    tatneft: 'Татнефть',
    lukoil: 'Лукойл',
    shell: 'Shell',
    gazprom: 'Газпром',
    bashneft: 'Башнефть',
  }

  const availableBrands = computed(() => {
    if (!config.value || !config.value.fuelBrands || !fuelType.value) return []
    const brands = config.value.fuelBrands[fuelType.value] || []
    return brands.map((b) => ({
      label: brandNameMap[b.toLowerCase()] || b.charAt(0).toUpperCase() + b.slice(1),
      value: b,
      icon: b, // Add icon property, assuming component name matches value
    }))
  })

  const availableServices = computed(() => {
    if (config.value && config.value.services) {
      return config.value.services.map((s) => ({
        label: s.label,
        value: s.value,
        icon: s.value,
        baseCircleColor: '#F1F1F1', // Default inactive color for service circles
        activeCircleColor: getServiceActiveCircleColor(s.value), // Unique active color for services
      }))
    }
    // fallback: hardcoded list (можно убрать, если бэкенд всегда возвращает)
    return [
      {
        label: 'Штрафы',
        value: 'fines',
        icon: 'fines',
        baseCircleColor: '#F1F1F1',
        activeCircleColor: getServiceActiveCircleColor('fines'),
      },
      {
        label: 'Парковки',
        value: 'parking',
        icon: 'parking',
        baseCircleColor: '#F1F1F1',
        activeCircleColor: getServiceActiveCircleColor('parking'),
      },
      {
        label: 'ЭДО',
        value: 'edo',
        icon: 'edo',
        baseCircleColor: '#F1F1F1',
        activeCircleColor: getServiceActiveCircleColor('edo'),
      },
      {
        label: 'Мойки',
        value: 'wash',
        icon: 'wash',
        baseCircleColor: '#F1F1F1',
        activeCircleColor: getServiceActiveCircleColor('wash'),
      },
      {
        label: 'Отсрочка',
        value: 'delay',
        icon: 'delay',
        baseCircleColor: '#F1F1F1',
        activeCircleColor: getServiceActiveCircleColor('delay'),
      },
      {
        label: 'Телематика',
        value: 'telematics',
        icon: 'telematics',
        baseCircleColor: '#F1F1F1',
        activeCircleColor: getServiceActiveCircleColor('telematics'),
      },
      {
        label: 'PPRPAY',
        value: 'pprpay',
        icon: 'pprpay',
        baseCircleColor: '#F1F1F1',
        activeCircleColor: getServiceActiveCircleColor('pprpay'),
      },
      {
        label: 'СМС',
        value: 'sms',
        icon: 'sms',
        baseCircleColor: '#F1F1F1',
        activeCircleColor: getServiceActiveCircleColor('sms'),
      },
      {
        label: 'Страховка',
        value: 'insurance',
        icon: 'insurance',
        baseCircleColor: '#F1F1F1',
        activeCircleColor: getServiceActiveCircleColor('insurance'),
      },
    ]
  })

  // Helper function to determine active circle color for services
  const getServiceActiveCircleColor = (serviceValue) => {
    switch (serviceValue) {
      case 'fines':
        return '#E53935' // Red for Fines
      case 'parking':
        return '#1A73E8' // Blue for Parking
      case 'edo':
        return '#00ACC1' // Cyan for EDO
      case 'wash':
        return '#63B6E4' // Light blue for Wash
      case 'delay':
        return '#FF8C00' // Dark Orange for Delay
      case 'telematics':
        return '#8E24AA' // Deep Purple for Telematics
      case 'pprpay':
        return '#4CAF50' // Green for PPRPAY
      case 'sms':
        return '#42D151' // Lime Green for SMS
      case 'insurance':
        return '#008B8B' // Dark Cyan for Insurance
      default:
        return '#FBCE07' // Default yellow for other services if no specific color is provided
    }
  }

  const fetchConfig = async () => {
    try {
      const response = await fetch('/backend/api.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          action: 'get_config',
        }),
      })
      const result = await response.json()
      console.log('fetchConfig: Backend response result:', result) // DIAGNOSTIC LOG 0
      if (result.status === 'success') {
        config.value = result.data
        // Set initial region based on fetched config if available
        if (config.value.regionMaxFuel) {
          const defaultRegionKey = Object.keys(config.value.regionMaxFuel)[0]
          region.value = {
            label: 'Ленинградская область',
            value: defaultRegionKey,
            max: config.value.regionMaxFuel[defaultRegionKey],
          }
        }
        // Explicitly set initial fuelType based on fetched config
        if (config.value.fuelPrices) {
          fuelType.value = Object.keys(config.value.fuelPrices)[0]
        }
        // Explicitly set initial brand based on fetched config
        if (config.value.allBrands && config.value.allBrands.length > 0) {
          brand.value = config.value.allBrands[0].value
        }
        console.log('fetchConfig: Config loaded. config.value:', config.value) // DIAGNOSTIC LOG 1
      } else {
        console.error('Failed to fetch config from backend:', result.message)
      }
    } catch (error) {
      console.error('Error fetching config:', error)
    }
  }

  // Initial fetch of config when component is mounted
  onMounted(async () => {
    await fetchConfig()
    console.log('onMounted: After fetchConfig, config.value is:', config.value) // DIAGNOSTIC LOG 2

    fetchCalculation() // Trigger initial calculation after config is loaded
  })

  const fetchCalculation = async () => {
    // Only proceed if config is loaded
    if (!config.value) {
      console.warn(
        'fetchCalculation: Config is NOT loaded, skipping. Current config.value:',
        config.value,
      ) // DIAGNOSTIC LOG 3
      return
    }

    // Use the computed property to get the currently available promos
    const promosForCurrentTariff = availablePromos.value

    if (promosForCurrentTariff.length > 0) {
      const mostAdvantageousPromo = promosForCurrentTariff[0] // Since availablePromos is already sorted highest first

      // Always try to set the most advantageous promo if it's not currently selected
      // This covers both cases: current promo is invalid OR current promo is valid but not the most advantageous.
      if (promo.value.value !== mostAdvantageousPromo.value) {
        promo.value = mostAdvantageousPromo
        console.log(
          'fetchCalculation: Promo updated to most advantageous for current tariff:',
          promo.value,
        ) // Debug Log
      }
    } else if (promo.value.value !== 0) {
      // If no promos are available for the current tariff, reset promo to 0
      promo.value = { label: '', value: 0, desc: '' }
      console.log('fetchCalculation: No valid tariff or promos, resetting promo to 0.') // Debug Log
    }

    console.log('fetchCalculation: Sending calculation request with:', {
      region: region.value.value,
      amount: Number(amount.value),
      fuelType: fuelType.value,
      promoAction: promo.value.value, // This is the value sent to backend
    }) // New Debug Log

    try {
      const response = await fetch('/backend/api.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          action: 'calculate',
          region: region.value.value,
          amount: Number(amount.value),
          fuelType: fuelType.value,
          promoAction: promo.value.value, // Now guaranteed to be a valid integer promo or 0 if no promos exist
        }),
      })
      const result = await response.json()

      if (result.status === 'success') {
        calculation.value = {
          monthlyCost: result.data.monthlyCost,
          monthlySavings: result.data.monthlySavings,
          yearlySavings: result.data.yearlySavings,
          tariffName: tariffNameMap[result.data.tariff] || result.data.tariff,
          totalDiscountPercentage: result.data.totalDiscountPercentage,
        }

        // Automatically select the first available brand if current one is not in new list
        if (!availableBrands.value.some((b) => b.value === brand.value)) {
          brand.value = availableBrands.value[0]?.value || ''
        }

        // Re-evaluate promo selection to always pick the most advantageous if available
        // This part is now handled at the start of fetchCalculation more comprehensively.
        // If promo changes based on user interaction, it will be validated and potentially reset before next request.
      } else {
        console.error('Backend calculation error:', result.message, result)
        // Optionally, reset calculation or show an error state
        calculation.value = {
          monthlyCost: 0,
          monthlySavings: 0,
          yearlySavings: 0,
          tariffName: '',
          totalDiscountPercentage: 0,
        }
        // availableBrands.value = []
        // availablePromos.value = []
      }
    } catch (error) {
      console.error('Failed to fetch calculation from backend:', error)
      // Optionally, reset calculation or show an error state
      calculation.value = {
        monthlyCost: 0,
        monthlySavings: 0,
        yearlySavings: 0,
        tariffName: '',
        totalDiscountPercentage: 0,
      }
      // availableBrands.value = []
      // availablePromos.value = []
    }
  }

  // Watchers for reactive variables to trigger re-calculation
  watch([region, fuelType, services], fetchCalculation, { deep: true })

  const triggerCalculation = () => {
    fetchCalculation()
  }

  return {
    region,
    amount,
    fuelType,
    brand,
    services,
    promo,
    availableBrands,
    availablePromos,
    calculation,
    fuelTypes, // экспортируем для FuelTypeTabs.vue
    regions, // экспортируем для RegionSelect.vue
    availableServices,
    triggerCalculation, // Expose the new function
  }
}
