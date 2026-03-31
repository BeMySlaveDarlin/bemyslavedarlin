<script setup>
import { ref } from 'vue'
import { useGlobalStore } from '@/store'
import controlsImg from '@/assets/sprites/space.png'

const store = useGlobalStore()
const nickInput = ref('')

async function submitNick() {
  const trimmed = nickInput.value.trim()
  if (trimmed.length >= 3 && trimmed.length <= 20) {
    await store.setNick(trimmed)
  }
}
</script>

<template>
  <div class="nick-row">
    <template v-if="store.player.nick">
      <span style="font-weight: 700">{{ store.player.nick }}</span>
    </template>
    <template v-else>
      <input
        v-model="nickInput"
        class="nick-input"
        placeholder="Enter nickname"
        maxlength="20"
        minlength="3"
        @click.stop
        @keydown.stop
      >
      <button class="nick-ok" @click.stop="submitNick">OK</button>
    </template>
  </div>
  <div class="controls-row">
    <span class="controls-label">Controls</span>
    <img :src="controlsImg" class="controls-img" alt="Controls">
  </div>
  <hr>
  <div v-if="store.info.items?.game" v-html="store.info.items.game.description"></div>
</template>
