<script>
import {mapActions} from "pinia"
import {useGlobalStore} from "@/store/index"
import infoImage from "@/assets/images/ui/buttons/info.gif"

export default {
  data() {
    return {
      currentImage: infoImage,
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
      this.togglePopup('gameInfo')
    }
  }
}
</script>

<template>
  <button @click="handleClick" class="info-button" title="How to play">
    <img :src="currentImage" alt="How to play"/>
  </button>
</template>

<style scoped>
.info-button {
  display: inline-block;
  border: none;
  background: none;
  padding: 0;
  cursor: pointer;
  position: relative;
  width: 48px;
  height: 48px;
}

.info-button img {
  width: 100%;
  height: 100%;
}

@media (max-width: 1024px) and (orientation: portrait) {
  .info-button {
    width: 96px;
    height: 96px;
  }
}
</style>
