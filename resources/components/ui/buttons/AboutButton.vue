<script>
import {mapActions} from "pinia"
import {useGlobalStore} from "@/store/index"
import aboutImage from "@/assets/images/ui/buttons/about.webp"

export default {
  data() {
    return {
      currentImage: aboutImage,
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
      this.togglePopup('about')
    }
  }
}
</script>

<template>
  <button @click="handleClick" class="about-button" title="About me">
    <img :src="currentImage" alt="About me"/>
  </button>
</template>

<style scoped>
.about-button {
  display: inline-block;
  border: none;
  background: none;
  padding: 0;
  cursor: pointer;
  position: relative;
  width: 48px;
  height: 48px;
}

.about-button img {
  width: 100%;
  height: 100%;
}

@media (max-width: 1024px) and (orientation: portrait) {
  .about-button {
    width: 96px;
    height: 96px;
  }
}
</style>
