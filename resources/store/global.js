import axios from 'axios'
import {defineStore} from 'pinia'
import coinSound from '@/assets/sounds/coin.mp3'
import poopSound from '@/assets/sounds/poop.mp3'

export const useGlobalStore = defineStore('global', {
	state: () => ({
		isIntersectingPoop: false,
		isIntersectingMoney: false,
		isIntersectingSkill: false,
		isSoundEnabled: true,
		jumpState: false,
		player: {
			nick: null,
			grade: 'Junior',
			money: 0,
			skills: [],
			quote: null,
		},
		contacts: {
			items: [],
			loading: false,
			error: null,
		},
		quotes: {
			items: [],
			loading: false,
			error: null,
		},
		info: {
			items: [],
			loading: false,
			error: null,
		},
		rating: {
			items: [],
			loading: false,
			error: null,
		},
	}),
	getters: {
		skillsCount(state) {
			return state.player.skills.length === 0 ? 1 : state.player.skills.length
		}
	},
	actions: {
		toggleSound() {
			this.isSoundEnabled = !this.isSoundEnabled
		},
		toggleJump() {
			this.jumpState = !this.jumpState
		},
		reset() {
			this.player.money = 0
			this.player.grade = 'Junior'
			this.player.skills = []
			this.player.quote = null
		},
		playSound(soundFile) {
			if (!this.isSoundEnabled) return
			const audio = new Audio(soundFile)
			audio.play().catch(error => {
				console.error("Error playing sound:", error)
			})
		},
		getRandomAmount(min, max) {
			return Math.floor(Math.random() * (max - min + 1)) + min
		},
		checkIntersection(rectA, rectB, type, element) {
			const isIntersecting = !(
				rectA.right < rectB.left ||
				rectA.left > rectB.right ||
				rectA.bottom < rectB.top ||
				rectA.top > rectB.bottom
			)

			if (type === 'poop') {
				if (isIntersecting) {
					this.isIntersectingPoop = true
					this.playSound(poopSound)
					this.setMoney(this.player.money - this.getRandomAmount(500, 1000) + (this.skillsCount * 2))

					if (this.player.skills.length > 0) {
						const randomIndex = Math.floor(Math.random() * this.player.skills.length)
						this.player.skills.splice(randomIndex, 1)
					}

					setTimeout(() => {
						this.isIntersectingPoop = false
					}, 3000)
				}
			}

			if (type === 'coin') {
				if (isIntersecting) {
					this.isIntersectingMoney = true
					this.playSound(coinSound)
					this.setMoney(this.player.money + this.getRandomAmount(100, 500) + (this.skillsCount * 10))
				} else {
					this.isIntersectingMoney = false
				}
			}

			if (type === 'skill') {
				if (isIntersecting) {
					this.isIntersectingSkill = true
					const data = element.dataset.name
					if (!this.player.skills.includes(data)) {
						this.player.skills.push(data)
					}
				} else {
					this.isIntersectingSkill = false
				}
			}
		},
		setMoney(value) {
			if (value < 0) {
				value = 0
			}
			this.player.money = value

			this.updateGrade()
		},
		getFormatterMoney() {
			if (this.player.money >= 1000000000) {
				return `${(this.player.money / 1000000000).toFixed(0)}B+`
			} else if (this.player.money >= 1000000) {
				return `${(this.player.money / 1000000).toFixed(0)}M`
			} else if (this.player.money >= 100000) {
				return `${(this.player.money / 1000).toFixed(0)}k`
			} else if (this.player.money >= 10000) {
				return `${(this.player.money / 1000).toFixed(0)}k`
			} else {
				return `${this.player.money}`
			}
		},
		updateGrade() {
			if (this.player.money < 2000) {
				this.player.grade = 'Junior'
			} else if (this.player.money >= 2000 && this.player.money < 4500) {
				this.player.grade = 'Middle'
			} else if (this.player.money >= 4500 && this.player.money < 7000) {
				this.player.grade = 'Senior'
			} else if (this.player.money >= 7000 && this.player.money < 15000) {
				this.player.grade = 'Junior+'
			} else if (this.player.money >= 15000 && this.player.money < 50000) {
				this.player.grade = 'Junior++'
			} else if (this.player.money >= 50000) {
				this.player.grade = 'Junior S+'
			}
		},
		async fetchContacts() {
			this.contacts.loading = true
			this.contacts.error = null
			try {
				const response = await axios.get('/api/contacts')
				this.contacts.items = response.data.data
			} catch (err) {
				this.contacts.error = err.message || 'Ошибка загрузки'
			} finally {
				this.contacts.loading = false
			}
		},
		async fetchQuotes() {
			this.quotes.loading = true
			this.quotes.error = null
			try {
				const response = await axios.get('/api/quotes')
				this.quotes.items = response.data.data
			} catch (err) {
				this.quotes.error = err.message || 'Ошибка загрузки'
			} finally {
				this.quotes.loading = false
			}
		},
		async fetchInfo() {
			this.info.loading = true
			this.info.error = null
			try {
				const response = await axios.get('/api/about')
				this.info.items = response.data.data
			} catch (err) {
				this.info.error = err.message || 'Ошибка загрузки'
			} finally {
				this.info.loading = false
			}
		},
		async fetchRating() {
			this.rating.loading = true
			this.rating.error = null
			try {
				const response = await axios.get('/api/rating')
				this.rating.items = response.data.data
			} catch (err) {
				this.rating.error = err.message || 'Ошибка загрузки'
			} finally {
				this.rating.loading = false
			}
		},
	},
	persist: {
		enabled: true,
		strategies: [{
			key: 'global-store',
			storage: localStorage,
		}],
	},
})
