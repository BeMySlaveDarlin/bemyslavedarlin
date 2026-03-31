<script setup>
import coinSrc from '@/assets/sprites/coin.png'

defineProps({
  speed: { type: Number, required: true },
  bottom: { type: Number, required: true },
})

const emit = defineEmits(['done'])
</script>

<template>
  <div
    class="scroll-item coin-item"
    :style="{ '--speed': speed + 's', bottom: bottom + 'px' }"
    @animationend="emit('done')"
  >
    <img :src="coinSrc" alt="coin">
  </div>
</template>
