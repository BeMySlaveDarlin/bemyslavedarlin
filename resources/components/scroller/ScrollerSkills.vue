<script>
import {useGlobalStore} from "@/store/index"
import ItemSkill from "@/components/scroller/items/ItemSkill.vue"

export default {
  components: {ItemSkill},
  props: {
    start: {
      type: Number,
      required: true
    }
  },
  data() {
    return {
      itemsList: [],
      images: [],
      removeTimeouts: {},
      itemId: 1,
    }
  },
  async created() {
    await this.loadImages()
  },
  computed: {
    conditions() {
      return useGlobalStore().conditions
    },
  },
  mounted() {
    this.createRandomScrollInterval()
  },
  methods: {
    async loadImages() {
      const images = import.meta.glob('@/assets/images/items/skills/items/*.webp', {eager: true})

      this.images = Object.keys(images).map((key) => {
        return key.split('/').pop().replace(/\.[^/.]+$/, "")
      })
    },
    getRandomImageName() {
      const randomIndex = Math.floor(Math.random() * this.images.length)
      return this.images[randomIndex]
    },
    createRandomScrollInterval() {
      const addItem = () => {
        const itemName = this.getRandomImageName()

        this.itemsList.push({id: this.itemId, name: itemName})

        this.scheduleRemoval(this.itemId)
        this.itemId++

        setTimeout(addItem, Math.floor((Math.random() * 20 + 5) * 2500))
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
    'conditions.isIntersectingSkill'(newValue) {
      if (newValue === true) {
        this.itemsList = this.itemsList.filter(item => !item.name)
      }
    }
  }
}
</script>

<template>
  <div class="skills">
    <template v-for="item in itemsList" :key="item.id">
      <ItemSkill
          :imageName="item.name"
          :itemId="item.id"
      />
    </template>
  </div>
</template>
