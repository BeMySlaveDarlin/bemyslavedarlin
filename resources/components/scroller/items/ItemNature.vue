<script setup>
defineProps({
  layer: { type: String, required: true },
  src: { type: String, required: true },
  speed: { type: Number, required: true },
  topOffset: { type: String, default: null },
  startOffset: { type: Number, default: 0 },
})

const emit = defineEmits(['done'])
</script>

<template>
  <div
    class="scroll-item"
    :class="layer"
    :style="{
      '--speed': speed + 's',
      ...(topOffset ? { top: topOffset } : {}),
      ...(startOffset ? { animationDelay: '-' + startOffset + 's' } : {}),
    }"
    @animationend="emit('done')"
  >
    <img :src="src" alt="">
  </div>
</template>
