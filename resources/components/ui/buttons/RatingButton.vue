<script>
import {mapActions} from "pinia"
import {useGlobalStore} from "@/store/index"
import leaderboardImage from "@/assets/images/ui/buttons/leaderboard.webp"

export default {
  data() {
    return {
      currentImage: leaderboardImage,
    }
  },
  computed: {
    player() {
      return useGlobalStore().player
    }
  },
  methods: {
    ...mapActions(useGlobalStore, ['togglePopup']),
    handleClick() {
      this.togglePopup('rating')
    }
  }
}
</script>

<template>
  <button @click="handleClick" class="rating-button" title="Top tier players">
    <img :src="currentImage" alt="Top tier players"/>
  </button>
</template>

<style scoped>
.rating-button {
  display: inline-block;
  border: none;
  background: none;
  padding: 0;
  cursor: pointer;
  position: relative;
  width: 48px;
  height: 48px;
}

.rating-button img {
  width: 100%;
  height: 100%;
}

@media (max-width: 1024px) and (orientation: portrait) {
  .rating-button {
    width: 96px;
    height: 96px;
  }
}
</style>
