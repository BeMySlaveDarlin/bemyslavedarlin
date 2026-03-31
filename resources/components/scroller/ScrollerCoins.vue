<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import ItemCoin from '@/components/scroller/items/ItemCoin.vue'

const items = ref([])
let nextId = 0
let spawnTimer = null
let isHidden = false

function rnd(min, max) { return min + Math.random() * (max - min) }
function isMobile() { return window.innerWidth <= 768 }

function spawnItem() {
  const mobile = isMobile()
  const bottom = mobile
    ? rnd(window.innerHeight * 0.36, window.innerHeight * 0.55)
    : rnd(120, 300)
  items.value.push({ id: nextId++, speed: rnd(13, 18), bottom })
  scheduleNext()
}

function scheduleNext() {
  if (isHidden) return
  spawnTimer = setTimeout(spawnItem, Math.floor((rnd(5, 25)) * 1700))
}

function removeItem(id) {
  const idx = items.value.findIndex(i => i.id === id)
  if (idx !== -1) items.value.splice(idx, 1)
}

function onVisibilityChange() {
  isHidden = document.hidden
  if (isHidden) { clearTimeout(spawnTimer) }
  else { items.value = []; scheduleNext() }
}

onMounted(() => {
  document.addEventListener('visibilitychange', onVisibilityChange)
  setTimeout(spawnItem, 2500)
})

onBeforeUnmount(() => {
  clearTimeout(spawnTimer)
  document.removeEventListener('visibilitychange', onVisibilityChange)
})
</script>

<template>
  <ItemCoin v-for="item in items" :key="item.id" :speed="item.speed" :bottom="item.bottom" @done="removeItem(item.id)" />
</template>
