<template>
        <div class="p-4 sm:p-6 md:p-8 max-w-5xl mx-auto">
     <button
                    @click="$router.go(-1)"
                    class="bg-vin_blanc hover:bg-gray-700 focus:bg-gray-700 text-white font-bold rounded-full cursor-pointer transform transition-all durtation-200 flex items-center"
                >
                    <i class="material-symbols-outlined py-4 px-4"> arrow_back </i>
                </button>

       <section class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <img :src="bouteille.photo" :alt="bouteille.nom" class="w-1/2 h-auto mx-auto rounded-md">
        </div>
        <div>
            <h1 class="text-xl font-bold text-vin-rouge mb-2">{{ bouteille.nom }}</h1>
            <p class="text-lg text-gray-700 mb-4">{{ bouteille.description }}</p>
            <p class="text-lg lg:text-xl text-gray-700 font-semibold mb-2">Prix:</p>
            <p class="text-gray-900 text-xl mb-4">{{ bouteille.prix }} $</p>

        </div>
    </section>
    <section class="mt-8 bg-white shadow-lg rounded-lg p-6 lg:p-8 mt-6">
        <h2 class="text-xl font-bold text-vin-rouge mb-4">Commentaires des clients</h2>


        <!-- Commentaire 1 -->
    <div class="border-b border-gray-300 pb-4 mb-4">
    <!-- Nom et date -->
    <div class="flex items-center mb-2">
      <h3 class="text-gray-900 font-semibold mr-2">John Doe</h3>
      <p class="text-gray-700 text-sm">5 janvier 2022</p>
    </div>

    <!-- Évaluation -->
    <div class="flex items-center mb-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-1" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10.000,0.000 L7.242,6.184 L0.000,7.047 L5.273,12.393 L4.242,19.000 L10.000,15.609 L15.758,19.000 L14.727,12.393 L20.000,7.047 L12.758,6.184 L10.000,0.000 Z" />
      </svg>
      <p class="text-gray-700 font-semibold">4 étoiles</p>
    </div>

    <!-- Contenu du commentaire -->
    <p class="text-gray-900 text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque interdum magna a magna eleifend luctus. Etiam interdum elit ac tortor faucibus, vel tristique velit bibendum. Donec ac ipsum id est molestie malesuada. Nulla facilisi. Integer feugiat vel augue vel vestibulum.</p>
    </div>
        <!-- Commentaire 2 -->
    <div class="border-b border-gray-300 pb-4 mb-4">
    <!-- Nom et date -->
    <div class="flex items-center mb-2">
      <h3 class="text-gray-900 font-semibold mr-2">Nicolas Cage</h3>
      <p class="text-gray-700 text-sm">5 janvier 2023</p>
    </div>

    <!-- Évaluation -->
    <div class="flex items-center mb-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-1" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10.000,0.000 L7.242,6.184 L0.000,7.047 L5.273,12.393 L4.242,19.000 L10.000,15.609 L15.758,19.000 L14.727,12.393 L20.000,7.047 L12.758,6.184 L10.000,0.000 Z" />
      </svg>
      <p class="text-gray-700 font-semibold">4 étoiles</p>
    </div>

    <!-- Contenu du commentaire -->
    <p class="text-gray-900 text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque interdum magna a magna eleifend luctus. Etiam interdum elit ac tortor faucibus, vel tristique velit bibendum. Donec ac ipsum id est molestie malesuada. Nulla facilisi. Integer feugiat vel augue vel vestibulum.</p>
    </div>
    </section>
    </div>
</template>



<script>
import BouteilleDataService from "@/services/BouteilleDataService.js";
export default {
    name: "BouteilleDetailsView",
    props: {
        id: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            bouteille: {},
        };
    },
    mounted() {
        // Call a method to fetch the bottle details using the id prop
        this.fetchBouteille(this.id);
    },
    methods: {
        async fetchBouteille(id) {
            try {
                const response = await BouteilleDataService.get(id);
                this.bouteille = response.data;
                console.log(this.bouteille)
            } catch (error) {
                console.log(error);
            }
        },
    },
};
</script>
