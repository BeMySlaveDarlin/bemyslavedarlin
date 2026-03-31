<script setup>
import { useGlobalStore } from '@/store'
import infoIcon from '@/assets/sprites/info.png'

const store = useGlobalStore()
</script>

<template>
  <button class="nav-btn" title="How to play" @click.stop="store.togglePopup('gameInfo')">
    <img :src="infoIcon" alt="Info">
  </button>
</template>
