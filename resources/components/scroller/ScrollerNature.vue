<script>
import ItemNature from "@/components/scroller/items/ItemNature.vue"

export default {
  components: {ItemNature},
  props: {
    itemType: {
      type: Text,
      required: true
    },
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
  mounted() {
    this.createRandomScrollInterval()
  },
  methods: {
    createRandomScrollInterval() {
      const addItem = () => {
        const randomNumber = Math.floor(Math.random() * 5) + 1
        this.itemsList.push({id: this.itemId, value: randomNumber})

        this.scheduleRemoval(this.itemId)
        this.itemId++

        setTimeout(addItem, Math.floor((Math.random() * 20 + 5) * 660))
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
  }
}
</script>

<template>
  <div class="objects">
    <template v-for="item in itemsList" :key="item.id">
      <ItemNature
          :imageNumber="item.value"
          :itemType="this.itemType"
          :itemId="item.id"
      />
    </template>
  </div>
</template>

<style scoped>
</style>
