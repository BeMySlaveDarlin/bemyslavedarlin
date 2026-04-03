<script setup>
import { onMounted, ref, watch } from 'vue'
import { useGlobalStore } from '@/store'
import logoImg from '@/assets/sprites/logo.png'
import GroundItem from '@/components/scroller/items/GroundItem.vue'
import ItemCharacter from '@/components/scroller/items/ItemCharacter.vue'
import ScrollerNature from '@/components/scroller/ScrollerNature.vue'
import ScrollerCoins from '@/components/scroller/ScrollerCoins.vue'
import ScrollerPoops from '@/components/scroller/ScrollerPoops.vue'
import ScrollerSkills from '@/components/scroller/ScrollerSkills.vue'
import ButtonsLeft from '@/components/ui/ButtonsLeft.vue'
import ButtonsRight from '@/components/ui/ButtonsRight.vue'
import PopupContainer from '@/components/ui/PopupContainer.vue'

const store = useGlobalStore()
const gameRef = ref(null)

function handleAction(e) {
  if (e.target.closest('.nav-left') || e.target.closest('.nav-right')) return
  if (e.target.closest('.popup-overlay')) return
  if (e.type === 'touchend') e.preventDefault()
  if (store.conditions.isPopupActive) return
  if (store.conditions.isJumpActive) return
  store.toggleJump()
  showQuote()
}

function handleKeydown(e) {
  if (e.code === 'Space') {
    e.preventDefault()
    if (store.conditions.isPopupActive) return
    if (store.conditions.isJumpActive) return
    store.toggleJump()
    showQuote()
  }
}

function showQuote() {
  if (!store.quotes.items.length) return
  const idx = Math.floor(Math.random() * store.quotes.items.length)
  store.player.quote = store.quotes.items[idx]?.description ?? store.quotes.items[idx]?.text ?? null
}

watch(() => store.conditions.isPopupActive, () => {
  if (!store.conditions.isPopupActive) gameRef.value?.focus()
})

onMounted(() => {
  store.conditions.isJumpActive = false
  store.conditions.isIntersectingPoop = false
  store.conditions.isIntersectingMoney = false
  store.conditions.isIntersectingSkill = false
  store.conditions.isPopupActive = false
  store.popups.about = false
  store.popups.gameInfo = false
  store.popups.rating = false
  store.player.quote = null
  gameRef.value?.focus()
  store.savePlayer()
  store.fetchQuotes()
  store.fetchInfo()
  store.fetchContacts()
})
</script>

<template>
  <div
    ref="gameRef"
    class="game"
    tabindex="0"
    @click="handleAction"
    @touchend="handleAction"
    @keydown="handleKeydown"
  >
    <header>
      <div class="masthead">
        <div class="masthead-logo">
          <img :src="logoImg" alt="logo" width="36" height="28" style="filter: sepia(20%) contrast(1.1)">
        </div>
        <h1>Be My Slave<span class="dot">,</span> Darlin<span class="dot">'</span></h1>
      </div>
      <div class="dateline">
        <span>Zen Programmer's Gazette</span>
        <span>Est. 2007 &bull; Edition of 2026</span>
        <span>PHP &bull; Symfony &bull; Vue</span>
      </div>
      <div class="quote-bar" :class="{ visible: store.player.quote }">
        {{ store.player.quote }}
      </div>
    </header>

    <ButtonsLeft />
    <ButtonsRight />

    <main id="gameArea">
      <GroundItem />

      <ScrollerNature layer-type="cloud-far" />
      <ScrollerNature layer-type="cloud-mid" />
      <ScrollerNature layer-type="cloud-near" />

      <ScrollerNature layer-type="tree-far" />
      <ScrollerNature layer-type="tree-back" />
      <ScrollerNature layer-type="tree-mid" />
      <ScrollerNature layer-type="tree-front" />

      <ScrollerNature layer-type="bush-back" />
      <ScrollerNature layer-type="bush-mid" />
      <ScrollerNature layer-type="bush-front" />

      <ItemCharacter />
      <ScrollerCoins />
      <ScrollerPoops />
      <ScrollerSkills />
    </main>

    <PopupContainer />
  </div>
</template>
