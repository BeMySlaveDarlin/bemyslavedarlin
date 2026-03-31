<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import ItemSkill from '@/components/scroller/items/ItemSkill.vue'

const skillModules = import.meta.glob('@/assets/images/items/skills/items/*.webp', { eager: true })
const skills = Object.entries(skillModules).map(([path, mod]) => ({
  name: path.split('/').pop().replace(/\.[^/.]+$/, ''),
  src: mod.default,
}))

const items = ref([])
let nextId = 0
let spawnTimer = null
let isHidden = false

function rnd(min, max) { return min + Math.random() * (max - min) }
function isMobile() { return window.innerWidth <= 768 }

function randomSkill() {
  return skills[Math.floor(Math.random() * skills.length)]
}

function spawnItem() {
  const mobile = isMobile()
  const bottom = mobile
    ? rnd(window.innerHeight * 0.40, window.innerHeight * 0.60)
    : rnd(150, 350)
  const skill = randomSkill()
  items.value.push({ id: nextId++, speed: rnd(16, 24), bottom, iconSrc: skill.src, skillName: skill.name })
  scheduleNext()
}

function scheduleNext() {
  if (isHidden) return
  spawnTimer = setTimeout(spawnItem, Math.floor((rnd(5, 25)) * 2500))
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
  setTimeout(spawnItem, 1500)
})

onBeforeUnmount(() => {
  clearTimeout(spawnTimer)
  document.removeEventListener('visibilitychange', onVisibilityChange)
})
</script>

<template>
  <ItemSkill
    v-for="item in items"
    :key="item.id"
    :speed="item.speed"
    :bottom="item.bottom"
    :icon-src="item.iconSrc"
    :skill-name="item.skillName"
    @done="removeItem(item.id)"
  />
</template>
