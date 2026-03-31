<script setup>
import { useGlobalStore } from '@/store'
import leaderboardIcon from '@/assets/sprites/cup.png'

const store = useGlobalStore()
</script>

<template>
  <button class="nav-btn" title="Top 10" @click.stop="store.togglePopup('rating')">
    <img :src="leaderboardIcon" alt="Rating">
  </button>
</template>
