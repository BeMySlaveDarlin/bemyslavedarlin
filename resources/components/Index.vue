<script>
import {mapActions, mapState} from "pinia"
import {useGlobalStore} from "@/store/global.js"
import ScrollerNature from "@/components/scroller/ScrollerNature.vue"
import GroundItem from "@/components/scroller/items/GroundItem.vue"
import ItemCharacter from "@/components/scroller/items/ItemCharacter.vue"
import ScrollerPoops from "@/components/scroller/ScrollerPoops.vue"
import ScrollerCoins from "@/components/scroller/ScrollerCoins.vue"
import ScrollerSkills from "@/components/scroller/ScrollerSkills.vue"
import LeftButtons from "@/components/ui/LeftButtons.vue"
import RightButtons from "@/components/ui/RightButtons.vue"

export default {
  components: {
    LeftButtons,
    RightButtons,
    ScrollerSkills,
    ScrollerPoops,
    ScrollerCoins,
    ScrollerNature,
    ItemCharacter,
    GroundItem
  },
  data() {
    return {
      cloudStartTime: 1100,
      bushStartTime: 2500,
      treeStartTime: 1500,
      treeSmallStartTime: 3500,
      coinsStartTime: 2300,
      poopsStartTime: 4200,
      skillsStartTime: 1200,
    }
  },
  computed: {
    ...mapState(useGlobalStore, ['player'])
  },
  mounted() {
    document.querySelector('.main-container').focus()
  },
  methods: {
    ...mapActions(useGlobalStore, ['toggleJump']),
    handleBlur() {
      document.querySelector('.main-container').focus()
    },
    handlePointer(event) {
      if (
          event.target.closest('.buttons-container') ||
          event.target.closest('.buttons-container')
      ) {
        return;
      }
      this.toggleJump();
    },
    handleSpace(event) {
      this.toggleJump();
    }
  }
}
</script>

<template>
  <div
      class="main-container"
      @click="handlePointer"
      @keydown.space="handleSpace"
      @touchstart="handlePointer"
      @blur="handleBlur"
      tabindex="0"
  >
    <header>
      <div v-if="player.quote !== null" class="quote-container">
        {{ player.quote.text }}
      </div>
      <LeftButtons/>
      <RightButtons/>
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
.quote-container {
  width: auto;
  height: auto;
  display: inline-block;
  position: relative;
  left: 50%;
  top: 10px;
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
