<script setup>
import { computed } from 'vue'
import { useGlobalStore } from '@/store'
import soundOnIcon from '@/assets/sprites/sond_on.png'
import soundOffIcon from '@/assets/sprites/sound_off.png'

const store = useGlobalStore()
const icon = computed(() => store.conditions.isSoundEnabled ? soundOnIcon : soundOffIcon)
</script>

<template>
  <button class="nav-btn" title="Sound" @click.stop="store.toggleSound()">
    <img :src="icon" alt="Sound">
  </button>
</template>
