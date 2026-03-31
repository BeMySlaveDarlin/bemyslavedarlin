<script setup>
import poopSrc from '@/assets/images/items/poop.gif'

defineProps({
  speed: { type: Number, required: true },
  bottom: { type: Number, required: true },
})

const emit = defineEmits(['done'])
</script>

<template>
  <div
    class="scroll-item poop-item"
    :style="{ '--speed': speed + 's', bottom: bottom + 'px' }"
    @animationend="emit('done')"
  >
    <img :src="poopSrc" alt="poop">
  </div>
</template>
