import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import api from '@/utils/api.js'

const coinSoundUrl = new URL('@/assets/sounds/coin.mp3', import.meta.url).href
const poopSoundUrl = new URL('@/assets/sounds/poop.mp3', import.meta.url).href

export const useGlobalStore = defineStore('user-store', () => {
	// --- State ---
	const player = ref({
		nick: null,
		grade: 'Junior',
		money: 0,
		skills: [],
		quote: null,
		fingerprint: null,
		error: null,
	})

	const conditions = ref({
		isSoundEnabled: true,
		isPopupActive: false,
		isJumpActive: false,
		isIntersectingPoop: false,
		isIntersectingMoney: false,
		isIntersectingSkill: false,
	})

	const popups = ref({
		about: false,
		gameInfo: false,
		rating: false,
	})

	const contacts = ref({
		items: [],
		loading: false,
		error: null,
	})

	const quotes = ref({
		items: [],
		loading: false,
		error: null,
	})

	const info = ref({
		items: [],
		loading: false,
		error: null,
	})

	const rating = ref({
		items: [],
		loading: false,
		error: null,
	})

	// --- Getters ---
	const skillsCount = computed(() =>
		player.value.skills.length === 0 ? 1 : player.value.skills.length
	)

	// --- Actions: Sound ---
	function toggleSound() {
		conditions.value.isSoundEnabled = !conditions.value.isSoundEnabled
	}

	function playSound(soundFile) {
		if (!conditions.value.isSoundEnabled) return
		const audio = new Audio(soundFile)
		audio.play().catch(() => {})
	}

	function playCoinSound() {
		playSound(coinSoundUrl)
	}

	function playPoopSound() {
		playSound(poopSoundUrl)
	}

	// --- Actions: Popup ---
	function togglePopup(type) {
		conditions.value.isPopupActive = !conditions.value.isPopupActive
		for (const key in popups.value) {
			popups.value[key] = false
		}
		if (type && type in popups.value) {
			popups.value[type] = !popups.value[type]
		}
	}

	// --- Actions: Player ---
	function resetState() {
		player.value.grade = 'Junior'
		player.value.money = 0
		player.value.skills = []
		player.value.quote = null
	}

	function getRandomAmount(min, max) {
		return Math.floor(Math.random() * (max - min + 1)) + min
	}

	function updateGrade() {
		const money = player.value.money
		if (money < 2000) {
			player.value.grade = 'Junior'
		} else if (money < 4500) {
			player.value.grade = 'Middle'
		} else if (money < 7000) {
			player.value.grade = 'Senior'
		} else if (money < 15000) {
			player.value.grade = 'Junior+'
		} else if (money < 50000) {
			player.value.grade = 'Junior++'
		} else if (money < 100000) {
			player.value.grade = 'Junior+++'
		} else {
			player.value.grade = 'Srunior'
		}
	}

	function setMoney(value) {
		if (value < 0) {
			value = 0
		}
		player.value.money = value
		updateGrade()
		savePlayer()
	}

	function formatMoney(money) {
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
	}

	function setNick(nick) {
		player.value.nick = nick
		if (!savePlayer()) {
			player.value.nick = null
		}
	}

	// --- Actions: API ---
	async function fetchContacts() {
		contacts.value.loading = true
		contacts.value.error = null
		try {
			const response = await api.get('/contacts')
			contacts.value.items = response.data.data
		} catch (err) {
			contacts.value.error = err.message || 'Ошибка загрузки'
		} finally {
			contacts.value.loading = false
		}
	}

	async function fetchInfo() {
		info.value.loading = true
		info.value.error = null
		try {
			const response = await api.get('/about')
			const items = response.data.data
			if (items && items.length > 0) {
				info.value.items = items.reduce((acc, item) => {
					acc[item.type] = item
					return acc
				}, {})
			}
		} catch (err) {
			info.value.error = err.message || 'Ошибка загрузки'
		} finally {
			info.value.loading = false
		}
	}

	async function fetchQuotes() {
		quotes.value.loading = true
		quotes.value.error = null
		try {
			const response = await api.get('/quotes')
			quotes.value.items = response.data.data
		} catch (err) {
			quotes.value.error = err.message || 'Ошибка загрузки'
		} finally {
			quotes.value.loading = false
		}
	}

	async function fetchRating() {
		rating.value.loading = true
		rating.value.error = null
		try {
			const response = await api.get('/rating')
			rating.value.items = response.data.data
		} catch (err) {
			rating.value.error = err.message || 'Ошибка загрузки'
		} finally {
			rating.value.loading = false
		}
	}

	async function savePlayer() {
		if (!player.value.fingerprint) return false

		try {
			const response = await api.post('/player', player.value)
			if (response.status <= 300) {
				player.value.error = null
				return true
			}
		} catch (error) {
			if (error.response.data.errorMessage === 'UNIQUE') {
				player.value.nick = null
			}
		}
		player.value.error = 'Ошибка сохранения'

		return false
	}

	// --- Actions: Collisions ---
	function toggleJump() {
		conditions.value.isJumpActive = !conditions.value.isJumpActive
	}

	function checkIntersection(rectA, rectB, type, element) {
		const isIntersecting = !(
			rectA.right < rectB.left ||
			rectA.left > rectB.right ||
			rectA.bottom < rectB.top ||
			rectA.top > rectB.bottom
		)

		function consumeElement(el) {
			if (!el) return
			el.style.display = 'none'
			el.dispatchEvent(new Event('animationend', { bubbles: true }))
		}

		if (type === 'poop' && isIntersecting && !conditions.value.isIntersectingPoop) {
			conditions.value.isIntersectingPoop = true
			playPoopSound()
			const loss = getRandomAmount(500, 1000) - (skillsCount.value * 10)
			setMoney(player.value.money - loss)
			if (player.value.skills.length > 0) {
				const randomIndex = Math.floor(Math.random() * player.value.skills.length)
				player.value.skills.splice(randomIndex, 1)
			}
			consumeElement(element)
			setTimeout(() => { conditions.value.isIntersectingPoop = false }, 3000)
		}

		if (type === 'coin' && isIntersecting && !conditions.value.isIntersectingMoney) {
			conditions.value.isIntersectingMoney = true
			playCoinSound()
			setMoney(player.value.money + getRandomAmount(100, 500) + (skillsCount.value * 10))
			consumeElement(element)
			conditions.value.isIntersectingMoney = false
		}

		if (type === 'skill' && isIntersecting && !conditions.value.isIntersectingSkill) {
			conditions.value.isIntersectingSkill = true
			const skillIcon = element.querySelector('.skill-icon')
			const skillName = skillIcon ? skillIcon.alt : null
			if (skillName && !player.value.skills.includes(skillName)) {
				player.value.skills.push(skillName)
				setMoney(player.value.money + 10)
			}
			consumeElement(element)
			conditions.value.isIntersectingSkill = false
		}
	}

	return {
		player,
		conditions,
		popups,
		contacts,
		quotes,
		info,
		rating,
		skillsCount,
		toggleSound,
		playSound,
		playCoinSound,
		playPoopSound,
		togglePopup,
		resetState,
		getRandomAmount,
		updateGrade,
		setMoney,
		formatMoney,
		setNick,
		fetchContacts,
		fetchInfo,
		fetchQuotes,
		fetchRating,
		savePlayer,
		toggleJump,
		checkIntersection,
	}
}, {
	persist: {
		key: 'user-store',
		storage: localStorage,
	},
})
