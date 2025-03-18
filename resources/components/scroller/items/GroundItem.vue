<script>
import {useGlobalStore} from "@/store/index"
import bubble from "@/assets/images/items/skills/bubble.webp"
import phpIcon from "@/assets/images/items/skills/items/php.webp"
import symfonyIcon from "@/assets/images/items/skills/items/symfony.webp"
import vuejsIcon from "@/assets/images/items/skills/items/vue.webp"

export default {
  data() {
    return {
      backgroundImage: bubble,
      phpIcon: phpIcon,
      symfonyIcon: symfonyIcon,
      vuejsIcon: vuejsIcon,
    }
  },
  computed: {
    player() {
      return useGlobalStore().player
    },
    currentYear() {
      return new Date().getFullYear()
    }
  },
  methods: {
    getImagePath(imageName) {
      return new URL(`/assets/images/items/skills/items/${imageName}.webp`, import.meta.url).href
    }
  }
}
</script>

<template>
  <div class="ground-background"></div>
  <div class="skills-list">
    <div v-for="skill in player.skills"
         :key="skill"
         :style="{ backgroundImage: `url(${backgroundImage})` }"
         class="skill-container"
    >
      <img
          :src="getImagePath(skill)"
          :alt="`Item ${skill}`"
          :title="`Skill: ${skill}`"
          :data-name="skill"
          class="skill-item"
      />
    </div>
  </div>
  <div class="info">
    <div class="copyright">
      <a target="_blank" href="https://github.com/BeMySlaveDarlin/bemyslavedarlin">BeMySlaveDarlin</a> © 2007 - {{ currentYear }}
    </div>
    <div class="powered-by">
      <span class="powered-text">Powered by:</span>
      <img :src="phpIcon" alt="PHP" class="tech-icon"/>
      <img :src="symfonyIcon" alt="Symfony" class="tech-icon"/>
      <img :src="vuejsIcon" alt="VueJS" class="tech-icon"/>
    </div>
  </div>
</template>

<style scoped>
.ground-background {
  position: absolute;
  bottom: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(to bottom, #81c631 20%, #6c4934 30%, #4e4037 50%);
}

.info {
  display: inline-block;
  position: absolute;
  width: auto;
  bottom: 0;
  right: 0;
  padding: 0.5rem;
  margin: auto;
}

.copyright, .powered-by {
  display: block;
  width: auto;
  height: auto;
  font-size: 1.2rem;
  color: white !important;
}

.copyright a {
  color: white !important;
}

.powered-by {
  display: flex;
  align-items: center;
}

.powered-text {
  font-size: 1.2rem;
  color: white;
  margin-right: 10px;
}

.tech-icon {
  width: 32px;
  height: 32px;
  margin-left: 10px;
}

.skills-list {
  display: block;
  position: absolute;
  width: 65%;
  top: 30%;
  padding: 0.5rem;
  margin: auto;
}

.skill-container {
  width: 24px;
  height: 24px;
  display: inline-block;
  overflow: hidden;
  position: relative;
  animation: scale 3s ease-in-out infinite;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  margin: 0 0.3rem;
}

.skill-item {
  width: 70%;
  height: 70%;
  position: relative;
  top: 15%;
  left: 15%;
}

@keyframes scale {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.15);
  }
  100% {
    transform: scale(1);
  }
}
</style>
