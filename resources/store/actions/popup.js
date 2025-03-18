export const popupActions = {
	togglePopup(type) {
		this.conditions.isPopupActive = !this.conditions.isPopupActive
		for (const key in this.popups) {
			this.popups[key] = false
		}
		if (type && type in this.popups) {
			this.popups[type] = !this.popups[type]
		}
	},
}
