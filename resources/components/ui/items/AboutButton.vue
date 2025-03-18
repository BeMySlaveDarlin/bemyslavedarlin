<script>
import {mapActions} from 'pinia'
import {useGlobalStore} from '@/store/global.js'
import aboutImage from '@/assets/images/ui/about.webp'

export default {
  data() {
    return {
      currentImage: aboutImage,
    }
  },
  methods: {
    ...mapActions(useGlobalStore, ['about']),
    handleClick() {
      console.log('click')
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
