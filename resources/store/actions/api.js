import api from "@/utils/api.js"

export const apiActions = {
	async fetchContacts() {
		this.contacts.loading = true
		this.contacts.error = null
		try {
			const response = await api.get('/contacts')
			this.contacts.items = response.data.data
		} catch (err) {
			this.contacts.error = err.message || 'Ошибка загрузки'
		} finally {
			this.contacts.loading = false
		}
	},
	async fetchInfo() {
		this.info.loading = true
		this.info.error = null
		try {
			const response = await api.get('/about')
			const items = response.data.data
			if (items && items.length > 0) {
				this.info.items = items.reduce((acc, item) => {
					acc[item.type] = item
					return acc
				}, {})
			}
		} catch (err) {
			this.info.error = err.message || 'Ошибка загрузки'
		} finally {
			this.info.loading = false
		}
	},
	async fetchQuotes() {
		this.quotes.loading = true
		this.quotes.error = null
		try {
			const response = await api.get('/quotes')
			this.quotes.items = response.data.data
		} catch (err) {
			this.quotes.error = err.message || 'Ошибка загрузки'
		} finally {
			this.quotes.loading = false
		}
	},
	async fetchRating() {
		this.rating.loading = true
		this.rating.error = null
		try {
			const response = await api.get('/rating')
			this.rating.items = response.data.data
		} catch (err) {
			this.rating.error = err.message || 'Ошибка загрузки'
		} finally {
			this.rating.loading = false
		}
	},
	async savePlayer() {
		if (!this.player.fingerprint) return false

		try {
			const response = await api.post('/player', this.player)
			if (response.status <= 300) {
				this.player.error = null
				return true
			}
		} catch (error) {
			if (error.response.data.errorMessage === 'UNIQUE') {
				this.player.nick = null
			}
		}
		this.player.error = 'Ошибка сохранения'

		return false
	}
}
