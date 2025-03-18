<script>
import {mapActions} from "pinia"
import {useGlobalStore} from "@/store/index"
import winner1 from "@/assets/images/ui/popup/winner1.webp"
import winner2 from "@/assets/images/ui/popup/winner2.webp"
import winner3 from "@/assets/images/ui/popup/winner3.webp"
import playerX from "@/assets/images/ui/popup/player.webp"

export default {
  data() {
    return {
      winner1,
      winner2,
      winner3,
      playerX,
    }
  },
  computed: {
    player() {
      return useGlobalStore().player
    },
    rating() {
      return useGlobalStore().rating
    }
  },
  mounted() {
    this.fetchRating()
  },
  methods: {
    ...mapActions(useGlobalStore, ['fetchRating', 'formatMoney']),
    getPlaceClass(index) {
      if (index === 0) return 'first'
      if (index === 1) return 'second'
      if (index === 2) return 'third'
      return 'other'
    },
    getNickWithLabel(player) {
      const suffix = this.player.fingerprint === player.fingerprint ? ' (Ты)' : ''
      if (!player.nick) {

      }
      return player.nick ? `${player.nick} ${suffix}` : 'Player_' + player.id + suffix
    },
    getWinnerIcon(index) {
      if (index === 0) return winner1
      if (index === 1) return winner2
      if (index === 2) return winner3
      return null
    }
  }
}
</script>

<template>
  <div class="popup-rules" v-if="rating.items && rating.items.length > 0">
    <table>
      <thead>
      <tr>
        <th>#</th>
        <th>Никнейм</th>
        <th>Грейд</th>
        <th>Баланс</th>
        <th>Умений</th>
      </tr>
      </thead>
      <tbody>
      <tr
          v-for="(player, index) in rating.items"
          :key="player.id"
          :class="getPlaceClass(index)"
      >
        <td class="column-place">
          <img v-if="getWinnerIcon(index)" :src="getWinnerIcon(index)" alt="Winner icon" class="winner-icon"/>
          <span v-if="index > 2">{{ index + 1 }}</span>
        </td>
        <td class="column-nick">{{ getNickWithLabel(player) }}</td>
        <td class="column-grade">{{ player.grade }}</td>
        <td class="column-money">{{ this.formatMoney(player.money) }}</td>
        <td>{{ player.skills ? player.skills.length : 0 }}</td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
.popup-rules table {
  width: 100%;
}

.popup-rules th, .popup-rules td {
  border: 1px solid transparent;
  padding: 3px 7px;
}

.popup-rules .first {
  background-color: #fee338;
}

.popup-rules .second {
  background-color: lavenderblush;
}

.popup-rules .third {
  background-color: burlywood;
}

.popup-rules th {
  background-color: rgb(96, 70, 55);
  color: white;
}

.popup-rules .other {
  background-color: #eee;
  color: black;
}

.popup-rules .winner-icon {
  width: 20px;
  height: 20px;
  margin-right: 5px;
}

.column-place, .column-grade, .column-money {
  text-align: center;
}
</style>
