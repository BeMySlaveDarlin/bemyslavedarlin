<script>
import {mapActions, mapState} from "pinia"
import {useGlobalStore} from "@/store/global.js"

export default {
  data() {
    return {}
  },
  mounted() {
  },
  computed: {
    ...mapState(useGlobalStore, ['player', 'info'])
  },
  methods: {
    ...mapActions(useGlobalStore, ['fetchInfo', 'fetchRating']),
  }
}
</script>

<template>
  <div class="popup-container">
  </div>
</template>

<style scoped>
</style>
