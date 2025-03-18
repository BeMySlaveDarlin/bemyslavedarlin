<script>
import {mapActions} from "pinia"
import {useGlobalStore} from "@/store/index"
import ButtonsLeft from "@/components/ui/ButtonsLeft.vue"
import ButtonsRight from "@/components/ui/ButtonsRight.vue"
import GroundItem from "@/components/scroller/items/GroundItem.vue"
import ItemCharacter from "@/components/scroller/items/ItemCharacter.vue"
import PopupContainer from "@/components/ui/PopupContainer.vue"
import ScrollerCoins from "@/components/scroller/ScrollerCoins.vue"
import ScrollerNature from "@/components/scroller/ScrollerNature.vue"
import ScrollerPoops from "@/components/scroller/ScrollerPoops.vue"
import ScrollerSkills from "@/components/scroller/ScrollerSkills.vue"

export default {
  components: {
    ButtonsLeft,
    ButtonsRight,
    GroundItem,
    ItemCharacter,
    PopupContainer,
    ScrollerCoins,
    ScrollerNature,
    ScrollerPoops,
    ScrollerSkills,
  },
  data() {
    return {
      bushStartTime: 2500,
      cloudStartTime: 1100,
      coinsStartTime: 2300,
      poopsStartTime: 4200,
      skillsStartTime: 1200,
      treeSmallStartTime: 3500,
      treeStartTime: 1500,
    }
  },
  computed: {
    player() {
      return useGlobalStore().player
    },
    popups() {
      return useGlobalStore().popups
    },
    conditions() {
      return useGlobalStore().conditions
    }
  },
  mounted() {
    this.savePlayer()
    this.fetchQuotes()
    this.fetchInfo()
    this.fetchContacts()
    this.setFocus()
  },
  methods: {
    ...mapActions(useGlobalStore, ['toggleJump', 'fetchContacts', 'fetchQuotes', 'fetchInfo', 'fetchRating', 'savePlayer']),
    handlePointer(event) {
      if (
          event.target.closest('.popup-overlay') ||
          event.target.closest('.buttons-container') ||
          this.conditions.isPopupActive
      ) {
        return
      }

      this.toggleJump()
    },
    handleSpace() {
      if (this.conditions.isPopupActive) return
      this.toggleJump()
    },
    setFocus() {
      if (this.conditions.isPopupActive) {
        document.querySelector('.main-container').blur()
      } else {
        document.querySelector('.main-container').focus()
      }
    }
  },
  watch: {
    'conditions.isPopupActive': function (newValue) {
      this.setFocus()
    }
  }
}
</script>

<template>
  <div
      class="main-container"
      @click="handlePointer"
      @keydown.space="handleSpace"
      @touchend="handlePointer"
      @touchcancel="handlePointer"
      @blur="setFocus"
      tabindex="0"
  >
    <PopupContainer v-if="conditions.isPopupActive"/>
    <header>
      <div v-if="player.quote !== null" class="quote-container">
        {{ player.quote.text }}
      </div>
      <ButtonsLeft/>
      <ButtonsRight/>
      <ScrollerNature itemType="cloud" :start="cloudStartTime" :isBottom="false"/>
    </header>
    <main>
      <ScrollerNature itemType="tree" :start="treeStartTime"/>
      <ScrollerNature itemType="bush" :start="bushStartTime"/>
      <ItemCharacter/>
      <ScrollerCoins :start="coinsStartTime"/>
      <ScrollerPoops :start="poopsStartTime"/>
      <ScrollerSkills :start="skillsStartTime"/>
      <ScrollerNature itemType="bush" :start="bushStartTime"/>
      <ScrollerNature itemType="tree-small" :start="treeSmallStartTime"/>
    </main>
    <footer>
      <GroundItem/>
    </footer>
  </div>
</template>

<style scoped>
.main-container {
  width: 100%;
  height: 100%;
  position: absolute;
  overflow: hidden;
  outline: none;
}

.quote-container {
  width: auto;
  height: auto;
  display: inline-block;
  position: relative;
  top: 10px;
  left: 50%;
  transform: translateX(-50%);
  white-space: pre-line;
  text-align: justify;
  z-index: 10;
  background-color: azure;
  font-size: 1.5rem;
  border-left: 4px solid #ccc;
  border-radius: 10px;
  box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);
  font-style: italic;
  padding: 20px 20px 20px 40px;
}

.quote-container::before {
  content: "“";
  font-size: 3rem;
  position: absolute;
  left: 10px;
  top: 10px;
  color: #ccc;
}

.quote-container::after {
  content: "”";
  font-size: 3rem;
  position: absolute;
  right: 10px;
  bottom: 10px;
  color: #ccc;
}

@media (max-width: 1024px) and (orientation: portrait) {
  .quote-container {
    font-size: 2rem;
  }
}
</style>
