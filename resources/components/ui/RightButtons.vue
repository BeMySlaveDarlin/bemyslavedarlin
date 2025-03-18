<script>
import {mapActions, mapState} from 'pinia'
import {useGlobalStore} from "@/store/global.js"
import ContactButton from "@/components/ui/items/ContactButton.vue"
import AboutButton from "@/components/ui/items/AboutButton.vue";

export default {
  components: {ContactButton, AboutButton},
  computed: {
    ...mapState(useGlobalStore, ['contacts'])
  },
  mounted() {
    this.fetchContacts()
  },
  methods: {
    ...mapActions(useGlobalStore, ['fetchContacts'])
  }
}
</script>

<template>
  <div class="buttons-container">
    <ContactButton :contact="contact" v-for="contact in contacts.items" :key="contact.type"/>
    <AboutButton/>
  </div>
</template>

<style scoped>
.buttons-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  position: absolute;
  top: 0;
  right: 0;
  padding-right: 10px;
  padding-top: 10px;
  z-index: 10;
}
</style>
