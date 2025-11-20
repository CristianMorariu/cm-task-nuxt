export default defineNuxtConfig({
  compatibilityDate: "2024-04-03",
  devtools: { enabled: true },

  css: ["~/assets/main.css"],

  postcss: {
    plugins: {
      tailwindcss: {},
      autoprefixer: {},
    },
  },

  modules: ["nuxt-toast", "shadcn-nuxt"],
  shadcn: {
    prefix: "Ui", // sau "" dacă vrei <Button> în loc de <UiButton>
    componentDir: "./components/ui", // recomand varianta asta, vezi doc-urile Nuxt
  },
});
