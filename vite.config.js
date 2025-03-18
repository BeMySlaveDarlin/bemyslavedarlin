import {defineConfig} from "vite"
import vue from "@vitejs/plugin-vue"
import {fileURLToPath, URL} from 'node:url'

export default defineConfig({
	root: './resources',
	publicDir: false,
	build: {
		sourcemap: false,
		assetsInlineLimit: 524288,
		rollupOptions: {
			input: {
				index: './resources/index.js'
			},
			output: {
				entryFileNames: 'assets/[name].js',
				chunkFileNames: 'assets/[name].js',
				assetFileNames: 'assets/[name].[ext]',
				manualChunks(id) {
					if (id.includes('node_modules')) {
						return 'vendor'
					}
					if (/\.(jpg|jpeg|png|webp|svg|bmp)$/i.test(id)) {
						return 'images'
					}
					if (/\.(gif)$/i.test(id)) {
						return 'gifs'
					}
					if (/\.(mp3)$/i.test(id)) {
						return 'audio'
					}
				}
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
