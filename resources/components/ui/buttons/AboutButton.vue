<script setup>
import { useGlobalStore } from '@/store'
import aboutIcon from '@/assets/sprites/question.png'

const store = useGlobalStore()
</script>

<template>
  <button class="nav-btn" title="About me" @click.stop="store.togglePopup('about')">
    <img :src="aboutIcon" alt="About">
  </button>
</template>
