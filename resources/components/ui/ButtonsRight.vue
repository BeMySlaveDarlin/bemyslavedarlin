<script>
import {useGlobalStore} from "@/store/index"
import ContactButton from "@/components/ui/buttons/ContactButton.vue"
import AboutButton from "@/components/ui/buttons/AboutButton.vue"

export default {
  components: {ContactButton, AboutButton},
  computed: {
    contacts() {
      return useGlobalStore().contacts
    }
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
