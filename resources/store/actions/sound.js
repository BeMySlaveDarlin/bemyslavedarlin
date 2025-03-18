import coinSound from "@/assets/sounds/coin.mp3"
import poopSound from "@/assets/sounds/poop.mp3"

export const soundActions = {
	toggleSound() {
		this.conditions.isSoundEnabled = !this.conditions.isSoundEnabled
	},
	playSound(soundFile) {
		if (!this.conditions.isSoundEnabled) return
		const audio = new Audio(soundFile)
		audio.play().catch(error => {
			console.error("Error playing sound:", error)
		})
	},
	playCoinSound() {
		this.playSound(coinSound)
	},
	playPoopSound() {
		this.playSound(poopSound)
	},
}
