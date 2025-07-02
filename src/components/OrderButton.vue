<template>
    <button
        class="w-full bg-[#FBCE07] hover:bg-yellow-400 text-black py-4 rounded-xl shadow-[0_8px_24px_#FBCE07]/30 transition mb-2 flex items-center justify-center gap-2 font-sans"
        style="font-family: 'Proxima Nova', Arial, Helvetica, sans-serif;">
        Заказать тариф «{{ tariffName }}»
        <span class="inline-block text-xl ml-2 align-middle">&#8594;</span>
    </button>
</template>

<script setup>
defineProps({
    tariffName: { type: String, default: '...' }
})
</script>