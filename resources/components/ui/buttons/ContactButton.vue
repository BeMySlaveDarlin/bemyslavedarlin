<script>

export default {
  props: {
    contact: {
      type: Object,
      required: true
    }
  },
  data() {
    const backgroundImage = new URL(`/assets/images/ui/contact/${this.contact.type}.webp`, import.meta.url).href

    return {
      backgroundImage
    }
  }
}
</script>

<template>
  <a class="contact-button" target="_blank" :title="contact.type" :href="contact.contact" :style="{backgroundImage: `url(${backgroundImage})`}"/>
</template>

<style scoped>
.contact-button {
  display: inline-block;
  border: none;
  padding: 0;
  cursor: pointer;
  position: relative;
  width: 48px;
  height: 48px;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

@media (max-width: 1024px) and (orientation: portrait) {
  .contact-button {
    width: 96px;
    height: 96px;
  }
}
</style>
