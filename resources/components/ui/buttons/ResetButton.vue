<script setup>
import { useGlobalStore } from '@/store'
import resetIcon from '@/assets/sprites/refresh_dark.png'

const store = useGlobalStore()

function handleReset() {
  store.resetState()
  store.savePlayer()
}
</script>

<template>
  <button class="nav-btn" title="Reset" @click.stop="handleReset">
    <img :src="resetIcon" alt="Reset">
  </button>
</template>
