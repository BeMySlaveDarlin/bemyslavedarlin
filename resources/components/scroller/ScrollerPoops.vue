<script>
import {useGlobalStore} from "@/store/index"
import ItemPoop from "@/components/scroller/items/ItemPoop.vue"

export default {
  components: {ItemPoop},
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
  mounted() {
    this.createRandomScrollInterval()
  },
  computed: {
    conditions() {
      return useGlobalStore().conditions
    }
  },
  methods: {
    createRandomScrollInterval() {
      const addItem = () => {
        this.itemsList.push({id: this.itemId, value: 1})
        this.scheduleRemoval(this.itemId)

        setTimeout(addItem, Math.floor((Math.random() * 10 + 5) * 2100))
        this.itemId++
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
    'conditions.isIntersectingPoop'(newValue) {
      if (newValue === true) {
        this.itemsList = []
      }
    }
  }
}
</script>

<template>
  <div class="poops">
    <template v-for="item in itemsList" :key="item.id">
      <ItemPoop
          ref="poop"
          :imageNumber="item.value"
          :itemId="item.id"
      />
    </template>
  </div>
</template>
