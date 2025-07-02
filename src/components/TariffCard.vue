<template>
    <div class="flex flex-col items-center py-8 px-6 w-full max-w-md mx-auto">
        <div class="flex flex-col items-center w-full mb-6">
            <div class="flex items-center gap-3 mb-8 w-full justify-center">
                <span class="text-gray-500 text-base">Подходящий тариф</span>
                <span
                    class="flex items-center bg-teal-400 text-white text-base font-semibold rounded-full px-5 py-2 gap-2 shadow-sm">
                    <StarIcon class="w-4 h-4" />
                    Избранный
                </span>
            </div>
            <div class="relative w-[370px] h-[230px] mb-8">
                <img src="@/../public/img/visa.png" alt="VISA" class="w-full h-full object-cover rounded-2xl shadow" />
            </div>
        </div>
        <a href="#"
            class="flex items-center gap-2 !text-gray-500 text-base font-normal mt-2 no-underline hover:underline">
            <span>
                <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10.5 0C4.70846 0 0 4.7126 0 10.5C0 16.2874 4.70846 21 10.5 21C16.2915 21 21 16.2874 21 10.5C21 4.7126 16.2915 0 10.5 0ZM10.5 18.9C5.87008 18.9 2.1 15.1299 2.1 10.5C2.1 5.87008 5.87008 2.1 10.5 2.1C15.1299 2.1 18.9 5.87008 18.9 10.5C18.9 15.1299 15.1299 18.9 10.5 18.9Z"
                        fill="#636363" />
                    <path
                        d="M14.1006 6.3329L5.498 9.764C5.09702 9.92522 5.15076 10.5081 5.57241 10.5949L9.32182 11.3349C9.49544 11.3679 9.62773 11.5044 9.6608 11.678L10.4049 15.4026C10.4917 15.8284 11.0746 15.8821 11.2358 15.477L14.6669 6.89924C14.8116 6.54373 14.4561 6.18821 14.1006 6.3329Z"
                        fill="#636363" />
                </svg>
            </span>
            Сеть АЗС на карте
        </a>
    </div>
</template>

<script setup>
import StarIcon from './icons/StarIcon.vue'
</script>