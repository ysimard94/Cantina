<template>
  <div :class="{ 'transform translate-x-full opacity-0': !menuOuvert, 'transform translate-x-0 opacity-100': menuOuvert }" class="fixed inset-0 transition-all duration-500">
    <div class="w-full h-full bg-black bg-opacity-90 flex">
      <nav class="h-full w-full flex flex-col justify-center">
        <router-link :to="{ name: 'saq-produits' }" class="w-full text-2xl text-white py-2 mt-auto" @click="fermerMenu">Obtenir les bouteilles SAQ</router-link>
        <router-link :to="{ name: 'catalogue.index' }" class="w-full text-2xl text-white py-2" @click="fermerMenu">Catalogue</router-link>
        <router-link :to="{ name: 'accueil' }" class="w-full text-2xl text-white py-2 mb-auto" @click="fermerMenu">À propos</router-link>
      </nav>
    </div>
    <button :class="{ 'transform -rotate-180 opacity-0': !menuOuvert, 'transform opacity-100': menuOuvert }" class="material-symbols-outlined text-white text-6xl absolute top-5 left-5 transition-all duration-500" @click="fermerMenu(); reinitialiserPage()">
      close
    </button>
  </div>
</template>

<script>
export default {
  name: "MenuComponent",
  props: {
    menuOuvert: Boolean
  },
  methods: {
    fermerMenu() {
      this.$emit("fermer-menu");
    },
    reinitialiserPage() {
      this.$emit("reinitialiser-page");
    },
  },
};
</script>
