import {defineConfig} from "vite"
import vue from "@vitejs/plugin-vue"
import {fileURLToPath, URL} from 'node:url'

export default defineConfig({
	root: './resources',
	publicDir: false,
	build: {
		rollupOptions: {
			input: {
				index: './resources/index.js'
			},
			output: {
				entryFileNames: 'assets/[name].js',
				chunkFileNames: 'assets/[name].js',
				assetFileNames: 'assets/[name].[ext]',
			},
		},
		outDir: '../public',
		emptyOutDir: false
	},
	watch: {
		include: './resources/**',
	},
	plugins: [
		vue()
	],
	resolve: {
		alias: {
			"~": fileURLToPath(new URL("./resources", import.meta.url)),
			"@": fileURLToPath(new URL("./resources", import.meta.url)),
		}
	}
})
