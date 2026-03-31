<script setup>
import bubbleSrc from '@/assets/sprites/bubble.png'

defineProps({
  speed: { type: Number, required: true },
  bottom: { type: Number, required: true },
  iconSrc: { type: String, required: true },
  skillName: { type: String, required: true },
})

const emit = defineEmits(['done'])
</script>

<template>
  <div
    class="scroll-item skill-item"
    :style="{ '--speed': speed + 's', bottom: bottom + 'px' }"
    @animationend="emit('done')"
  >
    <div class="skill-bubble">
      <img class="bubble-bg" :src="bubbleSrc" alt="">
      <img class="skill-icon" :src="iconSrc" :alt="skillName">
    </div>
  </div>
</template>
