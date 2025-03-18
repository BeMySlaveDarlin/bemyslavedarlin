export const getters = {
	skillsCount(state) {
		return state.player.skills.length === 0 ? 1 : state.player.skills.length
	}
}
