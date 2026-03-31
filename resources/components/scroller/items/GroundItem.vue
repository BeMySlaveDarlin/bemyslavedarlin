<script setup>
import { computed } from 'vue'
import { useGlobalStore } from '@/store'

const store = useGlobalStore()

const skillIcons = import.meta.glob('@/assets/images/items/skills/items/*.webp', { eager: true })

const collectedSkills = computed(() =>
  store.player.skills.map(name => {
    const key = Object.keys(skillIcons).find(k => k.includes(`/${name}.webp`))
    return key ? { name, src: skillIcons[key].default } : null
  }).filter(Boolean)
)
</script>

<template>
  <div class="ground-fill ground-4"></div>
  <div class="haze haze-3"></div>
  <div class="ground-fill ground-3"></div>
  <div class="haze haze-2"></div>
  <div class="ground-fill ground-2"></div>
  <div class="haze haze-1"></div>
  <div class="ground-fill ground-1"></div>

  <footer>
    <div class="skills-row">
      <img
        v-for="skill in collectedSkills"
        :key="skill.name"
        :src="skill.src"
        :alt="skill.name"
      >
    </div>
    <div class="footer-bar">
      <a href="https://github.com/BeMySlaveDarlin/bemyslavedarlin">BeMySlaveDarlin &copy; 2007&ndash;2026</a>
      <div class="footer-powered">Powered by: PHP &bull; Symfony &bull; Vue</div>
    </div>
  </footer>
</template>
