<script setup>
import { useGlobalStore } from '@/store'
import AboutPopup from '@/components/ui/popups/AboutPopup.vue'
import GameInfoPopup from '@/components/ui/popups/GameInfoPopup.vue'
import RatingPopup from '@/components/ui/popups/RatingPopup.vue'

const store = useGlobalStore()

function closeAll() {
  Object.keys(store.popups).forEach(k => { store.popups[k] = false })
  store.conditions.isPopupActive = false
}

function closeOverlay(e) {
  if (e.target.classList.contains('popup-overlay')) closeAll()
}
</script>

<template>
  <div class="popup-overlay" :class="{ active: store.popups.rating }" @click="closeOverlay">
    <div class="popup-page" @click.stop>
      <div class="popup-header">Топ 10</div>
      <button class="popup-close" @click="closeAll">&times;</button>
      <div class="popup-body">
        <RatingPopup />
      </div>
      <div class="popup-footer">&bull; &bull; &bull; &bull; &bull;</div>
    </div>
  </div>

  <div class="popup-overlay" :class="{ active: store.popups.gameInfo }" @click="closeOverlay">
    <div class="popup-page" @click.stop>
      <div class="popup-header">Правила игры</div>
      <button class="popup-close" @click="closeAll">&times;</button>
      <div class="popup-body">
        <GameInfoPopup />
      </div>
      <div class="popup-footer">&bull; &bull; &bull; &bull; &bull;</div>
    </div>
  </div>

  <div class="popup-overlay" :class="{ active: store.popups.about }" @click="closeOverlay">
    <div class="popup-page" @click.stop>
      <div class="popup-header">Об авторе</div>
      <button class="popup-close" @click="closeAll">&times;</button>
      <div class="popup-body">
        <AboutPopup />
      </div>
      <div class="popup-footer">&bull; &bull; &bull; &bull; &bull;</div>
    </div>
  </div>
</template>
