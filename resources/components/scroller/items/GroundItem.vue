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
    <div class="footer-projects">
      <a href="/ccb.html" class="project-link" title="CC-Bootstrapper">
        <svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M2 2h12v10H2z" stroke="currentColor" stroke-width="1.2"/>
          <path d="M5 5h6M5 8h4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
          <path d="M8 12v2M5 14h6" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
        </svg>
        CCB
      </a>
      <a href="/cctm.html" class="project-link" title="CC-Task-Manager">
        <svg width="14" height="14" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect x="2" y="1" width="12" height="14" rx="1" stroke="currentColor" stroke-width="1.2"/>
          <path d="M5 5h6M5 8h6M5 11h4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/>
        </svg>
        CCTM
      </a>
    </div>
    <div class="footer-bar">
      <a href="https://github.com/BeMySlaveDarlin/bemyslavedarlin">BeMySlaveDarlin &copy; 2007&ndash;2026</a>
      <div class="footer-powered">Powered by: PHP &bull; Symfony &bull; Vue</div>
    </div>
  </footer>
</template>
