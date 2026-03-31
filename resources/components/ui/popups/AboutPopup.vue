<script setup>
import { useGlobalStore } from '@/store'

const store = useGlobalStore()
</script>

<template>
  <div v-if="store.info.items?.about" v-html="store.info.items.about.description"></div>
</template>
