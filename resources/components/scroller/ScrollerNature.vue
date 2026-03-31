<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import ItemNature from '@/components/scroller/items/ItemNature.vue'

const props = defineProps({
  layerType: { type: String, required: true },
})

const LAYER_CONFIG = {
  'cloud-far':  { speedRange: [35, 50], interval: [6000, 12000], sprites: 'cloud',      initialCount: 1, initialDelay: 100 },
  'cloud-mid':  { speedRange: [25, 38], interval: [5000, 9000],  sprites: 'cloud',      initialCount: 1, initialDelay: 400 },
  'cloud-near': { speedRange: [18, 28], interval: [5000, 10000], sprites: 'cloud',      initialCount: 1, initialDelay: 700 },
  'tree-far':   { speedRange: [36, 36], interval: [5000, 9000],  sprites: 'tree-small', initialCount: 2, initialDelay: 0 },
  'tree-back':  { speedRange: [28, 28], interval: [4000, 7000],  sprites: 'tree',       initialCount: 3, initialDelay: 100 },
  'tree-mid':   { speedRange: [20, 20], interval: [3000, 6000],  sprites: 'tree',       initialCount: 2, initialDelay: 200 },
  'tree-front': { speedRange: [14, 14], interval: [4000, 7000],  sprites: 'tree',       initialCount: 1, initialDelay: 600 },
  'bush-back':  { speedRange: [28, 28], interval: [4000, 7000],  sprites: 'bush',       initialCount: 2, initialDelay: 100 },
  'bush-mid':   { speedRange: [20, 20], interval: [3000, 5500],  sprites: 'bush',       initialCount: 2, initialDelay: 300 },
  'bush-front': { speedRange: [14, 14], interval: [3500, 6000],  sprites: 'bush',       initialCount: 1, initialDelay: 400 },
}

const spriteModules = {
  cloud: import.meta.glob('@/assets/sprites/cloud*.png', { eager: true }),
  tree: import.meta.glob('@/assets/sprites/tree[0-9]*.png', { eager: true }),
  'tree-small': import.meta.glob('@/assets/sprites/tree[0-9]*.png', { eager: true }),
  bush: import.meta.glob('@/assets/sprites/bush*.png', { eager: true }),
}

function rnd(min, max) {
  return min + Math.random() * (max - min)
}

function getSpriteList() {
  const config = LAYER_CONFIG[props.layerType]
  const modules = spriteModules[config.sprites]
  return Object.values(modules).map(m => m.default)
}

function getTopOffset() {
  if (!props.layerType.startsWith('cloud-')) return null
  const mobile = window.innerWidth <= 768
  const ranges = {
    'cloud-far':  mobile ? [15, 30] : [100, 200],
    'cloud-mid':  mobile ? [8, 20]  : [50, 140],
    'cloud-near': mobile ? [3, 12]  : [10, 80],
  }
  const [min, max] = ranges[props.layerType]
  return mobile ? rnd(min, max) + 'vh' : rnd(min, max) + 'px'
}

const items = ref([])
let nextId = 0
let spawnTimer = null
let isHidden = false

function spawnItem(startOffset = 0) {
  const config = LAYER_CONFIG[props.layerType]
  const sprites = getSpriteList()
  if (!sprites.length) return

  items.value.push({
    id: nextId++,
    src: sprites[Math.floor(Math.random() * sprites.length)],
    speed: rnd(config.speedRange[0], config.speedRange[1]),
    topOffset: getTopOffset(),
    startOffset,
  })

  scheduleNext()
}

function scheduleNext() {
  if (isHidden) return
  const config = LAYER_CONFIG[props.layerType]
  spawnTimer = setTimeout(spawnItem, rnd(config.interval[0], config.interval[1]))
}

function removeItem(id) {
  const idx = items.value.findIndex(i => i.id === id)
  if (idx !== -1) items.value.splice(idx, 1)
}

function onVisibilityChange() {
  isHidden = document.hidden
  if (isHidden) {
    clearTimeout(spawnTimer)
  } else {
    items.value = []
    scheduleNext()
  }
}

onMounted(() => {
  document.addEventListener('visibilitychange', onVisibilityChange)
  const config = LAYER_CONFIG[props.layerType]
  for (let i = 0; i < config.initialCount; i++) {
    const speed = rnd(config.speedRange[0], config.speedRange[1])
    const offset = rnd(speed * 0.1, speed * 0.85)
    setTimeout(() => spawnItem(offset), config.initialDelay + i * 300)
  }
})

onBeforeUnmount(() => {
  clearTimeout(spawnTimer)
  document.removeEventListener('visibilitychange', onVisibilityChange)
})
</script>

<template>
  <ItemNature
    v-for="item in items"
    :key="item.id"
    :layer="layerType"
    :src="item.src"
    :speed="item.speed"
    :top-offset="item.topOffset"
    :start-offset="item.startOffset || 0"
    @done="removeItem(item.id)"
  />
</template>
