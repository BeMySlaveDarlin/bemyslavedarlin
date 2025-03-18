<script>
import ResetButton from "@/components/ui/items/ResetButton.vue"
import SoundButton from "@/components/ui/items/SoundButton.vue"
import InfoButton from "@/components/ui/items/InfoButton.vue"
import RatingButton from "@/components/ui/items/RatingButton.vue";

export default {
  components: {SoundButton, ResetButton, InfoButton, RatingButton}
}
</script>

<template>
  <div class="buttons-container">
    <RatingButton/>
    <InfoButton/>
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
