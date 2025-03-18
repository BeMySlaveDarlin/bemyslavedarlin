<script>
import coinGif from '@/assets/images/items/coin.gif'

export default {
  props: {
    itemId: {
      type: Number,
      required: true
    },
    imageNumber: {
      type: Number,
      required: true
    }
  },
  data() {
    return {}
  },
  methods: {
    getImagePath() {
      return coinGif
    }
  }
}
</script>

<template>
  <div class="coin-container">
    <img
        :src="getImagePath()"
        :alt="`Item ${imageNumber}`"
        class="coin-item"
    />
  </div>
</template>

<style scoped>
.coin-container {
  width: 80px;
  height: 80px;
  display: inline;
  overflow: hidden;
  position: absolute;
  right: -200px;
  bottom: 300px;
  animation: scroll-left 20s linear forwards;
  user-select: none;
}

@media (max-width: 1024px) and (orientation: portrait) {
  .coin-container {
    animation-duration: 15s;
  }
}

.coin-item {
  width: 100%;
  height: 100%;
  position: absolute;
  user-select: none;
}

@media (max-width: 1024px) and (orientation: portrait) {
  .coin-container {
    bottom: 400px;
  }
}

@keyframes scroll-left {
  from {
    right: -200px;
  }
  to {
    right: 200%;
  }
}
</style>
