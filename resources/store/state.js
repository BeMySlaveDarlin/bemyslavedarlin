export const state = () => ({
	player: {
		nick: null,
		grade: 'Junior',
		money: 0,
		skills: [],
		quote: null,
		fingerprint: null,
		error: null,
	},
	conditions: {
		isSoundEnabled: true,
		isPopupActive: false,
		isJumpActive: false,
		isIntersectingPoop: false,
		isIntersectingMoney: false,
		isIntersectingSkill: false,
	},
	popups: {
		about: false,
		gameInfo: false,
		rating: false,
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
})
