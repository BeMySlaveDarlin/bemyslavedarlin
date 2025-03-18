<script>
import poopGif from "@/assets/images/items/poop.gif"

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
      return poopGif
    }
  }
}
</script>

<template>
  <div class="poop-container">
    <img
        :src="getImagePath()"
        :alt="`Item ${imageNumber}`"
        class="poop-item"
    />
  </div>
</template>

<style scoped>
.poop-container {
  width: 64px;
  height: 64px;
  display: inline;
  overflow: hidden;
  position: absolute;
  right: -200px;
  bottom: 5px;
  animation: scroll-left 15s linear forwards;
}

@media (max-width: 1024px) and (orientation: portrait) {
  .poop-container {
    animation-duration: 10s;
  }
}

.poop-item {
  width: 100%;
  height: 100%;
  position: absolute;
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
