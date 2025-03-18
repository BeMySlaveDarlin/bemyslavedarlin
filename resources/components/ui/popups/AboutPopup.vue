<script>
import {useGlobalStore} from "@/store/index"

export default {
  data() {
    return {}
  },
  computed: {
    player() {
      return useGlobalStore().player
    },
    info() {
      return useGlobalStore().info
    }
  },
  methods: {}
}
</script>

<template>
  <div class="popup-about" v-html="info.items.about.description"></div>
</template>

<style scoped>
</style>
