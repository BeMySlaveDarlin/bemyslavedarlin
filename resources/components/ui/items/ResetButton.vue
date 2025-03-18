<script>
import {mapActions} from 'pinia'
import {useGlobalStore} from '@/store/global.js'
import resetImage from '@/assets/images/ui/reset.webp'
import resetClickImage from '@/assets/images/ui/reset-click.webp'

export default {
  data() {
    return {
      currentImage: resetImage,
    }
  },
  methods: {
    ...mapActions(useGlobalStore, ['reset']),
    handleClick() {
      this.currentImage = resetClickImage
      setTimeout(() => {
        this.currentImage = resetImage
      }, 500)
      this.reset()
    }
  }
}
</script>

<template>
  <button @click="handleClick" class="reset-button">
    <img :src="currentImage" alt="Reset data"/>
  </button>
</template>

<style scoped>
.reset-button {
  display: inline-block;
  border: none;
  background: none;
  padding: 0;
  cursor: pointer;
  position: relative;
  width: 48px;
  height: 48px;
}

.reset-button img {
  width: 100%;
  height: 100%;
}

@media (max-width: 1024px) and (orientation: portrait) {
  .reset-button {
    width: 96px;
    height: 96px;
  }
}
</style>
