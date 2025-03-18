<script>
import bubble from '@/assets/images/items/skills/bubble.webp'

export default {
  props: {
    itemId: {
      type: Number,
      required: true
    },
    imageName: {
      type: Text,
      required: true
    }
  },
  data() {
    return {
      backgroundImage: bubble,
      randomMargin: this.generateRandomMargin(),
    }
  },
  methods: {
    generateRandomMargin() {
      return `${Math.floor(Math.random() * 300) + 50}px`
    },
    getImagePath(imageName) {
      return new URL(`/assets/images/items/skills/items/${imageName}.webp`, import.meta.url).href
    }
  }
}
</script>

<template>
  <div :style="{ bottom: this.randomMargin, backgroundImage: `url(${this.backgroundImage})` }"
       class="skill-container"
  >
    <img
        :src="getImagePath(imageName)"
        :alt="`Item ${imageName}`"
        :data-name="imageName"
        class="skill-item"
    />
  </div>
</template>

<style scoped>
.skill-container {
  width: 50px;
  height: 50px;
  display: inline;
  overflow: hidden;
  position: absolute;
  right: -200px;
  bottom: 300px;
  animation: scroll-left 20s linear forwards, scale 3s ease-in-out infinite;
  user-select: none;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

@media (max-width: 1024px) and (orientation: portrait) {
  .skill-container {
    animation-duration: 15s;
  }
}

.skill-item {
  width: 60%;
  height: 60%;
  position: relative;
  top: 20%;
  left: 20%;
  user-select: none;
}

@keyframes scroll-left {
  from {
    right: -200px;
  }
  to {
    right: 200%;
  }
}

@keyframes scale {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.15);
  }
  100% {
    transform: scale(1);
  }
}
</style>
