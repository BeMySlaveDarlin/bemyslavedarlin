<script setup>
import { computed } from 'vue'
import { useGlobalStore } from '@/store'
import ContactButton from '@/components/ui/buttons/ContactButton.vue'
import AboutButton from '@/components/ui/buttons/AboutButton.vue'

import telegramIcon from '@/assets/sprites/telegram.png'
import githubIcon from '@/assets/sprites/github.png'
import gmailIcon from '@/assets/sprites/mail.png'

const store = useGlobalStore()

const contactIcons = { telegram: telegramIcon, github: githubIcon, gmail: gmailIcon }

const contactList = computed(() =>
  store.contacts.items.map(c => ({
    ...c,
    iconSrc: contactIcons[c.type] || telegramIcon,
  }))
)
</script>

<template>
  <div class="nav-right">
    <ContactButton
      v-for="contact in contactList"
      :key="contact.type"
      :href="contact.contact"
      :icon-src="contact.iconSrc"
      :label="contact.type"
    />
    <AboutButton />
  </div>
</template>
