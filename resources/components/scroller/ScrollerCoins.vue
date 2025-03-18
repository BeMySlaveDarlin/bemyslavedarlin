<script>
import {mapState} from 'pinia'
import {useGlobalStore} from '@/store/global.js'
import ItemCoin from "@/components/scroller/items/ItemCoin.vue"

export default {
  components: {ItemCoin},
  props: {
    start: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      itemsList: [],
      removeTimeouts: {},
      itemId: 1,
    }
  },
  computed: {
    ...mapState(useGlobalStore, ['isIntersectingMoney'])
  },
  mounted() {
    this.createRandomScrollInterval()
  },
  methods: {
    createRandomScrollInterval() {
      const addItem = () => {
        this.itemsList.push({id: this.itemId, value: 1})

        this.scheduleRemoval(this.itemId)
        this.itemId++

        setTimeout(addItem, Math.floor((Math.random() * 20 + 5) * 1700))
      }

      setTimeout(addItem, this.start)
    },
    scheduleRemoval(itemId) {
      this.removeTimeouts[itemId] = setTimeout(() => {
        const indexToRemove = this.itemsList.findIndex(item => item.id === itemId)
        if (indexToRemove !== -1) {
          this.itemsList.splice(indexToRemove, 1)
          delete this.removeTimeouts[itemId]
        }
      }, 20000)
    }
  },
  watch: {
    isIntersectingMoney(newValue) {
      if (newValue === true) {
        this.itemsList = []
      }
    }
  }
}
</script>

<template>
  <div class="coins">
    <template v-for="item in itemsList" :key="item.id">
      <ItemCoin
          ref="poop"
          :imageNumber="item.value"
          :itemId="item.id"
      />
    </template>
  </div>
</template>

<style scoped>
</style>
