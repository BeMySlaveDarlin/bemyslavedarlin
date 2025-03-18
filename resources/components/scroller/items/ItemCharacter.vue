<script>
import {mapActions, mapState} from 'pinia'
import {useGlobalStore} from '@/store/global.js'
import charImage from '@/assets/images/items/char/char.webp'
import charPoopedImage from '@/assets/images/items/char/char-pooped.webp'
import medalImage from '@/assets/images/items/char/medal.webp'
import moneyImage from '@/assets/images/items/char/money.webp'

export default {
  data() {
    return {
      charImage: charImage,
      medalImage: medalImage,
      moneyImage: moneyImage,
      intervals: [],
      jumping: false,
      jumpTime: 2,
    }
  },
  computed: {
    ...mapState(useGlobalStore, ['player', 'quotes', 'isIntersectingPoop', 'jumpState'])
  },
  mounted() {
    this.updateJumpTime()
    window.addEventListener("resize", this.updateJumpTime)

    this.charImage = charImage
    this.fetchQuotes()
    this.startIntersectionCheck('poop')
    this.startIntersectionCheck('coin')
    this.startIntersectionCheck('skill')
  },
  beforeUnmount() {
    window.removeEventListener("resize", this.updateJumpTime)
  },
  methods: {
    ...mapActions(useGlobalStore, ['checkIntersection', 'fetchQuotes', 'toggleJump', 'getFormatterMoney']),
    getImagePath(isIntersectingPoop) {
      return isIntersectingPoop ? charPoopedImage : charImage
    },
    jump() {
      if (this.jumping) return
      const element = document.querySelector('.character-container')
      if (!element) return

      this.jumping = true

      const randomIndex = Math.floor(Math.random() * this.quotes.items.length)
      this.player.quote = this.quotes.items[randomIndex]

      const height = element.offsetHeight

      element.style.transition = 'bottom ' + this.jumpTime + 's ease'
      element.style.bottom = `${parseInt(element.style.bottom || 0) + (height * 2)}px`

      setTimeout(() => {
        element.style.transition = 'bottom ' + this.jumpTime + 's ease'
        element.style.bottom = '12px'


        setTimeout(() => {
          element.style.transition = ''
          element.style.bottom = ''
          this.jumping = false
          this.player.quote = null
        }, this.jumpTime * 1000)
      }, this.jumpTime * 700)
    },
    startIntersectionCheck(type) {
      this.intervals[type] = setInterval(() => {
        const character = document.querySelector('.character-container');
        const object = document.querySelector('.' + type + '-item')
        if (character && object) {
          const rectA = character.getBoundingClientRect()
          const rectB = object.getBoundingClientRect()
          this.checkIntersection(rectA, rectB, type, object)
        }
      }, 16)
    },
    updateJumpTime() {
      const isSmallScreen = window.matchMedia("(max-width: 1024px) and (orientation: portrait)").matches
      this.jumpTime = isSmallScreen ? 2.8 : 2
    }
  },
  watch: {
    isIntersectingPoop(newValue) {
      this.charImage = this.getImagePath(newValue)
    },
    jumpState(newValue) {
      if (newValue) {
        this.jump()
        this.toggleJump()
      }
    }
  }
}
</script>

<template>
  <div class="character-container">
    <div class="character-badge grade-badge">
      <img :src="medalImage" alt="Medal" class="badge-icon"/>
      {{ player.grade }}
    </div>
    <div class="character-badge money-badge">
      <img :src="moneyImage" alt="Money" class="badge-icon"/>
      {{ player.money }}
    </div>
    <div class="character-image">
      <img
          :src="this.charImage"
          :class="isIntersectingPoop ? 'pooped' : ''"
          alt="Character"
          class="character-item"
      />
    </div>
  </div>
</template>

<style scoped>

.character-badge {
  width: 100%;
  position: absolute;
  font-family: 'Heebo', sans-serif;
  font-size: 1rem;
  font-weight: bold;
  text-transform: uppercase;
  padding: 0.2rem 0 0.2rem 0.5rem;
  margin: 0.1rem;
  user-select: none;
  left: -20px;
}

.money-badge {
  top: -50px;
  color: #428800;
  background: #ddffad;
}

.grade-badge {
  top: -80px;
  color: #0b5cb8;
  background: #a6f7f4;
}

@media (max-width: 1024px) and (orientation: portrait) {
  .character-badge {
    font-size: 1.2rem;
  }
}

.badge-icon {
  position: relative;
  top: 2px;
  width: 16px;
  height: 16px;
}

.character-container {
  width: 125px;
  height: 175px;
  position: absolute;
  bottom: 12px;
  left: 30%;
  animation: float 3s ease-in-out infinite;
  cursor: pointer;
  outline: none;
  user-select: none;
}

@media (max-width: 1024px) and (orientation: portrait) {
  .character-container {
    width: 180px;
    height: 250px;
  }
}

.character-item {
  position: absolute;
  width: 100%;
  height: 100%;
}

@keyframes float {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-15px);
  }
}
</style>
