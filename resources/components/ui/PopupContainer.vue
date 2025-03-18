<script>
import {mapActions} from "pinia"
import {useGlobalStore} from "@/store/index"
import woodImg from "@/assets/images/ui/popup/wood.webp"
import grassImg from "@/assets/images/ui/popup/grass.webp"
import AboutPopup from "@/components/ui/popups/AboutPopup.vue"
import GameInfoPopup from "@/components/ui/popups/GameInfoPopup.vue"
import RatingPopup from "@/components/ui/popups/RatingPopup.vue"

export default {
  components: {AboutPopup, GameInfoPopup, RatingPopup},
  data() {
    return {
      headerBackgroundImage: woodImg,
      bodyBackgroundImage: grassImg,
    }
  },
  computed: {
    player() {
      return useGlobalStore().player
    },
    info() {
      return useGlobalStore().info
    },
    popups() {
      return useGlobalStore().popups
    },
    conditions() {
      return useGlobalStore().conditions
    }
  },
  methods: {
    ...mapActions(useGlobalStore, ['togglePopup']),
    getTitle() {
      if (this.popups.about) {
        return this.info.items.about.title
      }
      if (this.popups.gameInfo) {
        return this.info.items.game.title
      }
      if (this.popups.rating) {
        return 'Топ 10'
      }
    },
    closePopup(event) {
      if (
          event.target.closest('.nickname') ||
          event.target.closest('.confirm-nickname')
      ) return

      this.togglePopup()
    }
  }
}
</script>

<template>
  <div :class="conditions.isPopupActive ? 'visible' : ''"
      @click="closePopup"
      @touchstart="closePopup"
      class="popup-overlay">
    <div class="popup-content">
      <div class="popup-header" :style="{ backgroundImage: `url(${headerBackgroundImage})` }">
        {{ getTitle() }}
      </div>
      <div class="popup-body" :style="{ backgroundImage: `url(${bodyBackgroundImage})` }">
        <AboutPopup v-if="popups.about"/>
        <GameInfoPopup v-if="popups.gameInfo"/>
        <RatingPopup v-if="popups.rating"/>
      </div>
    </div>
  </div>
</template>

<style scoped>
.popup-overlay {
  width: 100%;
  height: 100%;
  position: absolute;
  overflow: hidden;
  z-index: 999;
  opacity: 0;
  transform: translateY(-20px);
  transition: opacity 1.2s ease, transform 2s ease;
}

.popup-overlay.visible {
  opacity: 1;
  transform: translateY(0);
}

.popup-content {
  position: absolute;
  top: 35%;
  left: 50%;
  max-width: 80%;
  transform: translate(-50%, -50%);
  width: auto;
  height: auto;
  border: 1px solid #8f6246;
  border-radius: 12px;
  display: flex;
  flex-direction: column;
}

.popup-header {
  position: relative;
  width: 100%;
  height: auto;
  font-size: 1.5rem;
  font-weight: bold;
  background-repeat: repeat-x;
  padding: 10px;
  text-align: center;
  text-shadow: 2px 2px 3px #000;
  color: #fff;
  border-bottom: 1px solid #8f6246;
  border-radius: 12px 12px 0 0;
}

.popup-body {
  flex-grow: 1;
  position: relative;
  width: 100%;
  height: 100%;
  font-size: 1.2rem;
  line-height: 1.5em;
  font-weight: bold;
  background-repeat: repeat;
  padding: 20px;
  text-align: justify;
  color: #000;
}

@media (max-width: 1024px) and (orientation: portrait) {
  .popup-content {
    min-width: 65%;
  }

  .popup-body {
    font-size: 1.5rem;
  }
}
</style>
