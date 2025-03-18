<script>
import {mapActions} from "pinia"
import {useGlobalStore} from "@/store/index"
import controlsImg from "@/assets/images/ui/popup/controls.webp"

export default {
  data() {
    return {
      tempNickname: null,
      controlsImg,
    }
  },
  computed: {
    player() {
      return useGlobalStore().player
    },
    info() {
      return useGlobalStore().info
    }
  },
  methods: {
    ...mapActions(useGlobalStore, ['setNick']),
    confirmNickname() {
      if (this.tempNickname.length > 0) {
        this.setNick(this.tempNickname)
      }
    }
  }
}
</script>

<template>
  <div class="nickname">
    <template v-if="player.nick && player.nick.length > 0">
      <div class="nickname-label">Ник:</div>
      <span class="nickname-display">{{ player.nick }}</span>
    </template>
    <template v-else>
      <input
          v-model="tempNickname"
          class="nickname-input"
          placeholder="Введи ник"
          type="text"
          autocomplete="off"/>
      <button
          class="confirm-nickname"
          @click="confirmNickname"
          :class="!tempNickname ? 'disabled' : ''"
          :disabled="!tempNickname"
          v-html="`OK`"
      />
    </template>
  </div>
  <div v-if="player.error" class="nickname-error">
    {{ player.error }}
  </div>
  <div class="game-controls">
    <div class="controls-label">Управление</div>
    <div class="controls-image" :style="{ backgroundImage: `url(${controlsImg})` }"></div>
  </div>
  <div class="popup-rules" v-html="info.items.game.description"></div>
</template>

<style scoped>
.game-controls {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: row;
  gap: 10px;
  margin-bottom: 15px;
}

.controls-label, .nickname-label {
  line-height: 1;
}

.controls-image {
  width: 150px;
  height: 50px;
  background-repeat: no-repeat;
  background-position: center center;
  background-size: contain;
}

.nickname {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: row;
  gap: 10px;
  margin-bottom: 15px;
}

.nickname-display {
  font-family: 'Press Start 2P', cursive;
  font-size: 2rem;
  color: #000;
}

.nickname-error {
  font-family: 'Press Start 2P', cursive;
  font-size: 1rem;
  text-align: center;
  color: #ff0000;
}

.nickname-input {
  font-family: 'Press Start 2P', cursive;
  font-size: 1.2rem;
  padding: 2px 5px;
  background-color: #d1f5ff;
  color: #000;
  border: 1px solid #d6d6d6;
  border-radius: 2px;
  width: 20rem;
  height: 3rem;
  outline: none;
}

.nickname-input::placeholder {
  color: #000;
}

.nickname-input:focus {
  border: 1px solid #ffffff;
}

.confirm-nickname {
  font-family: "Press Start 2P", cursive;
  font-size: 1.2rem;
  padding: 2px 10px;
  background-color: #4eb0d7;
  color: #fff;
  border: 1px solid #d6d6d6;
  border-radius: 5px;
  outline: none;
  width: 3rem;
  height: 3rem;
}

.confirm-nickname.disabled {
  background-color: #b1cde4;
  color: #bfbfbf;
}

.confirm-nickname:hover {
  border: 1px solid #ffffff;
  color: #fff;
}

@media (max-width: 1024px) and (orientation: portrait) {
  .nickname-input {
    font-size: 1.8rem;
  }
}
</style>
