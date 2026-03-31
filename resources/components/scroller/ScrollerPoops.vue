<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import ItemPoop from '@/components/scroller/items/ItemPoop.vue'

const items = ref([])
let nextId = 0
let spawnTimer = null
let isHidden = false

function rnd(min, max) { return min + Math.random() * (max - min) }
function isMobile() { return window.innerWidth <= 768 }

function spawnItem() {
  const mobile = isMobile()
  const bottom = mobile
    ? rnd(window.innerHeight * 0.27, window.innerHeight * 0.32)
    : rnd(35, 45)
  items.value.push({ id: nextId++, speed: rnd(11, 16), bottom })
  scheduleNext()
}

function scheduleNext() {
  if (isHidden) return
  spawnTimer = setTimeout(spawnItem, Math.floor((rnd(5, 15)) * 2100))
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
  setTimeout(spawnItem, 4000)
})

onBeforeUnmount(() => {
  clearTimeout(spawnTimer)
  document.removeEventListener('visibilitychange', onVisibilityChange)
})
</script>

<template>
  <ItemPoop v-for="item in items" :key="item.id" :speed="item.speed" :bottom="item.bottom" @done="removeItem(item.id)" />
</template>
