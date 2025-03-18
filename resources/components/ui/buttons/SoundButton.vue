<script>
import {mapActions} from "pinia"
import {useGlobalStore} from "@/store/index"
import soundOn from "@/assets/images/ui/buttons/sound-on.webp"
import soundOff from "@/assets/images/ui/buttons/sound-off.webp"

export default {
  data() {
    return {
      soundOn,
      soundOff,
    }
  },
  computed: {
    conditions() {
      return useGlobalStore().conditions
    }
  },
  methods: {
    ...mapActions(useGlobalStore, ['toggleSound'])
  }
}
</script>

<template>
  <button @click="toggleSound" class="sound-button">
    <img :src="conditions.isSoundEnabled ? soundOn : soundOff" alt="Sound Toggle"/>
  </button>
</template>

<style scoped>
.sound-button {
  display: inline-block;
  border: none;
  background: none;
  padding: 0;
  cursor: pointer;
  position: relative;
  width: 48px;
  height: 48px;
}

.sound-button img {
  width: 100%;
  height: 100%;
}

@media (max-width: 1024px) and (orientation: portrait) {
  .sound-button {
    width: 96px;
    height: 96px;
  }
}
</style>
