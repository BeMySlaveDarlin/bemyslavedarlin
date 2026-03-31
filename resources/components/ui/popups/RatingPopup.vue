<script setup>
import { onMounted } from 'vue'
import { useGlobalStore } from '@/store'

import winner1 from '@/assets/sprites/first_place.png'
import winner2 from '@/assets/sprites/second_place.png'
import winner3 from '@/assets/sprites/third_place.png'

const store = useGlobalStore()

const placeIcons = { 0: winner1, 1: winner2, 2: winner3 }

onMounted(() => {
  store.fetchRating()
})
</script>

<template>
  <table class="rating-table">
    <thead>
      <tr>
        <th class="col-place">#</th>
        <th>Никнейм</th>
        <th>Грейд</th>
        <th class="col-money">Баланс</th>
        <th class="col-skills">Умений</th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="(item, idx) in store.rating.items"
        :key="idx"
        :class="{
          'place-1': idx === 0,
          'place-2': idx === 1,
          'place-3': idx === 2,
        }"
      >
        <td class="col-place">
          <img v-if="placeIcons[idx]" :src="placeIcons[idx]" class="place-icon">
          <span v-else>{{ idx + 1 }}</span>
        </td>
        <td :class="{ 'is-you': item.is_current }">
          {{ item.nick || 'Anonymous' }}
          <span v-if="item.is_current"> (You)</span>
        </td>
        <td>{{ item.grade }}</td>
        <td class="col-money">{{ store.formatMoney(item.money) }}</td>
        <td class="col-skills">{{ item.skills_count ?? 0 }}</td>
      </tr>
    </tbody>
  </table>
</template>
