import {defineStore} from "pinia"
import {state} from "./state"
import {getters} from "./getters"
import {apiActions} from "./actions/api"
import {soundActions} from "./actions/sound"
import {popupActions} from "./actions/popup"
import {playerActions} from "./actions/player"
import {collisionsActions} from "./actions/collisions"

export const useGlobalStore = defineStore('user-store', {
	state: state,
	getters,
	actions: {
		...apiActions,
		...soundActions,
		...popupActions,
		...playerActions,
		...collisionsActions,
	},
	persist: {
		enabled: true,
		strategies: [{
			key: 'user-store',
			storage: localStorage,
		}],
	},
})
