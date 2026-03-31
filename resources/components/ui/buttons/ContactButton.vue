<script setup>
defineProps({
  href: { type: String, required: true },
  iconSrc: { type: String, required: true },
  label: { type: String, required: true },
})
</script>

<template>
  <a class="nav-btn" :href="href" target="_blank" :title="label" @click.stop>
    <img :src="iconSrc" :alt="label">
  </a>
</template>
