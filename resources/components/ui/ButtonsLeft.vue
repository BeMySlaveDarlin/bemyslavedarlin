<script>
import ResetButton from "@/components/ui/buttons/ResetButton.vue"
import SoundButton from "@/components/ui/buttons/SoundButton.vue"
import GameInfoButton from "@/components/ui/buttons/GameInfoButton.vue"
import RatingButton from "@/components/ui/buttons/RatingButton.vue"

export default {
  components: {SoundButton, ResetButton, GameInfoButton, RatingButton}
}
</script>

<template>
  <div class="buttons-container">
    <RatingButton/>
    <GameInfoButton/>
    <SoundButton/>
    <ResetButton/>
  </div>
</template>

<style scoped>
.buttons-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  position: absolute;
  top: 0;
  left: 0;
  padding-left: 10px;
  padding-top: 10px;
  z-index: 10;
}
</style>
