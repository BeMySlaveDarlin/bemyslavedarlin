export const playerActions = {
	resetState() {
		this.player.grade = 'Junior'
		this.player.money = 0
		this.player.skills = []
		this.player.quote = null
	},
	setNick(nick) {
		this.player.nick = nick

		if (!this.savePlayer()) {
			this.player.nick = null
		}
	},
	getRandomAmount(min, max) {
		return Math.floor(Math.random() * (max - min + 1)) + min
	},
	setMoney(value) {
		if (value < 0) {
			value = 0
		}
		this.player.money = value

		this.updateGrade()
		this.savePlayer()
	},
	formatMoney(money) {
		if (money >= 1000000000) {
			return `${(money / 1000000000).toFixed(0)}B+`
		} else if (money >= 1000000) {
			return `${(money / 1000000).toFixed(0)}M`
		} else if (money >= 100000) {
			return `${(money / 1000).toFixed(0)}k`
		} else if (money >= 10000) {
			return `${(money / 1000).toFixed(0)}k`
		} else {
			return `${money}`
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
		} else if (this.player.money >= 50000 && this.player.money < 100000) {
			this.player.grade = 'Junior+++'
		} else if (this.player.money >= 100000) {
			this.player.grade = 'Srunior'
		}
	},
}
