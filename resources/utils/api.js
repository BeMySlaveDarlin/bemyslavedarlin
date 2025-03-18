import axios from "axios"
import {useGlobalStore} from "@/store/index"
import {getFingerprint} from "@/utils/fingerprint"

const api = axios.create({
	baseURL: "/api",
})

api.interceptors.request.use(async (config) => {
	const store = useGlobalStore()
	if (!store.player.fingerprint) {
		store.player.fingerprint = await getFingerprint()
	}
	config.headers["X-Fingerprint"] = store.player.fingerprint
	return config
}, (error) => Promise.reject(error))

export default api
