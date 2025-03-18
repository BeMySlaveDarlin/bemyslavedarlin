export const collisionsActions = {
	toggleJump() {
		this.conditions.isJumpActive = !this.conditions.isJumpActive
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
				this.conditions.isIntersectingPoop = true
				this.playPoopSound()
				this.setMoney(this.player.money - this.getRandomAmount(500, 1000) + (this.skillsCount * 2))

				if (this.player.skills.length > 0) {
					const randomIndex = Math.floor(Math.random() * this.player.skills.length)
					this.player.skills.splice(randomIndex, 1)
				}

				setTimeout(() => {
					this.conditions.isIntersectingPoop = false
				}, 3000)
			}
		}

		if (type === 'coin') {
			if (isIntersecting) {
				this.conditions.isIntersectingMoney = true
				this.playCoinSound()
				this.setMoney(this.player.money + this.getRandomAmount(100, 500) + (this.skillsCount * 10))
			} else {
				this.conditions.isIntersectingMoney = false
			}
		}

		if (type === 'skill') {
			if (isIntersecting) {
				this.conditions.isIntersectingSkill = true
				const data = element.dataset.name
				if (!this.player.skills.includes(data)) {
					this.player.skills.push(data)
					this.setMoney(this.player.money + 10)
				}
			} else {
				this.conditions.isIntersectingSkill = false
			}
		}
	},
}
