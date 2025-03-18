<script>
export default {
  props: {
    itemId: {
      type: Number,
      required: true
    },
    imageNumber: {
      type: Number,
      required: true
    },
    itemType: {
      type: Text,
      required: true
    }
  },
  data() {
    return {
      randomMargin: `-${Math.floor(Math.random() * 10)}px`,
    }
  },
  methods: {
    getImagePath(itemType, imageNumber) {
      return new URL(`/assets/images/items/objects/${itemType}${imageNumber}.webp`, import.meta.url).href
    }
  }
}
</script>

<template>
  <div v-if="itemType === 'cloud'"
       :style="{ bottom: randomMargin }"
       class="object-container top"
  >
    <img
        :src="getImagePath(itemType, imageNumber)"
        :alt="`Item ${imageNumber}`"
        class="scroller-item top"
    />
  </div>
  <div v-if="itemType === 'tree' || itemType === 'bush' || itemType === 'tree-small'"
       :class="`object-` + itemType"
       class="object-container bottom"
  >
    <img
        :src="getImagePath(itemType, imageNumber)"
        :alt="`Item ${imageNumber}`"
        class="scroller-item bottom"
    />
  </div>
</template>

<style scoped>
.object-container {
  display: inline;
  overflow: hidden;
  position: absolute;
  right: -200px;
  animation: scroll-left 20s linear forwards;
}

.object-container.top {
  width: 130px;
  height: 100px;
}

.object-container.bottom {
  width: 200px;
  height: 250px;
}

.object-container.object-tree {
  bottom: 20px;
}

.object-container.object-tree-small {
  bottom: 0;
}

.object-container.object-bush {
  bottom: 10px;
}

.scroller-item {
  width: 100%;
  height: 100%;
  position: absolute;
}

.scroller-item.bottom {
  transform-origin: bottom center;
  animation: bend 2s infinite ease-in-out alternate;
}

.scroller-item.top {
  transition: transform 0.5s ease-in-out;
  animation: scale 3s infinite ease-in-out;
}

@media (max-width: 1024px) and (orientation: portrait) {
  .object-container {
    animation-duration: 15s;
  }
  .object-container.top {
    width: 260px;
    height: 200px;
  }

  .object-container.bottom {
    width: 280px;
    height: 350px;
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

@keyframes bend {
  0% {
    transform: skewX(-3deg) scaleY(1.05);
  }
  100% {
    transform: skewX(3deg) scaleY(1);
  }
}

@keyframes scale {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
  }
}
</style>
