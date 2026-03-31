<script setup>
import { ref, computed, watch, onMounted, onBeforeUnmount } from 'vue'
import { useGlobalStore } from '@/store'
import charImage from '@/assets/sprites/char.png'
import charPoopedImage from '@/assets/sprites/char-pooped.png'
import medalIcon from '@/assets/sprites/medal.png'
import moneyIcon from '@/assets/sprites/coins.png'

const store = useGlobalStore()
const characterRef = ref(null)
let collisionInterval = null
let jumping = false

const currentImg = computed(() =>
  store.conditions.isIntersectingPoop ? charPoopedImage : charImage
)

function isMobile() {
  return window.innerWidth <= 768
}

function jump() {
  if (jumping) return
  const ch = characterRef.value
  if (!ch) return
  jumping = true

  const mobile = isMobile()
  const jumpTime = mobile ? 2.8 : 2
  const restBottom = mobile ? 'calc(27vh - 8px)' : '35px'
  const charHeight = ch.offsetHeight
  const currentBottom = parseInt(getComputedStyle(ch).bottom) || 0
  const jumpTarget = (currentBottom + charHeight * 2) + 'px'

  ch.style.transition = `bottom ${jumpTime}s ease`
  ch.style.bottom = jumpTarget

  setTimeout(() => {
    ch.style.transition = `bottom ${jumpTime}s ease`
    ch.style.bottom = restBottom

    setTimeout(() => { store.player.quote = null }, jumpTime * 3000)
    setTimeout(() => {
      ch.style.transition = ''
      jumping = false
      store.toggleJump()
    }, jumpTime * 1000)
  }, jumpTime * 700)
}

function startCollisionDetection() {
  collisionInterval = setInterval(() => {
    if (!characterRef.value || store.conditions.isPopupActive) return
    const charRect = characterRef.value.getBoundingClientRect()

    document.querySelectorAll('.coin-item').forEach(el => {
      store.checkIntersection(charRect, el.getBoundingClientRect(), 'coin', el)
    })
    document.querySelectorAll('.poop-item').forEach(el => {
      store.checkIntersection(charRect, el.getBoundingClientRect(), 'poop', el)
    })
    document.querySelectorAll('.skill-item').forEach(el => {
      store.checkIntersection(charRect, el.getBoundingClientRect(), 'skill', el)
    })
  }, 16)
}

watch(() => store.conditions.isJumpActive, (active) => {
  if (active) jump()
})

onMounted(() => {
  startCollisionDetection()
})

onBeforeUnmount(() => {
  clearInterval(collisionInterval)
})
</script>

<template>
  <div ref="characterRef" class="character">
    <div class="char-badge badge-grade">
      <img :src="medalIcon" alt="">
      <span>{{ store.player.grade }}</span>
    </div>
    <div class="char-badge badge-money">
      <img :src="moneyIcon" alt="" style="width:14px;height:14px">
      <span>{{ store.formatMoney(store.player.money) }}</span>
    </div>
    <img :src="currentImg" alt="Character">
  </div>
</template>
