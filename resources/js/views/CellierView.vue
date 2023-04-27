<template>
    <div class="container mx-auto px-2">

          <div class="flex items-center">
        <label for="select-cellier" class="mr-4 font-medium text-gray-700"> celliers :</label>
        <select id="select-cellier" v-model="selectedCellier" class="mr-4 p-2 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
          <option disabled>-- Sélectionner un cellier --</option>
          <option v-for="(cellier, index) in celliers" :key="index" :value="cellier">
            {{ cellier.nom }}
          </option>
        </select>
        <router-link to="/ajouter-cellier">
        <button class="px-4 py-2 rounded-md bg-vin_rouge text-white hover:bg-vin_blanc focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
          </svg>
          <span class="sr-only">Ajouter un cellier</span>
        </button>
    </router-link>
      </div>


             <div
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8 h-full"
            >
                <div
                    class="bg-bg_rose flex flex-col overflow-hidden shadow rounded-lg py-2 m-2 h-full"
                    v-for="bouteille in bouteilles"
                    :key="bouteille.id"
                >
                    <img
                        :src="bouteille.photo"
                        :alt="bouteille.nom"
                        class="w-1/3 mx-auto"
                    />

                    <div class="px-4 pt-4 flex flex-col justify-between">
                        <h4
                            class="text-lg font-serif font-semibold text-vin-rouge text-left h-[67px] leading-tight"
                        >
                            {{ bouteille.nom }}
                        </h4>
                        <div class="mt-4 flex justify-between items-center">
                            <div class="font-sans text-gray-700">
                                <div class="font-medium text-left">
                                    {{ bouteille.pays.nom }}
                                </div>
                                <div class="font-medium text-left">
                                    {{ bouteille.categorie.nom }}
                                </div>
                            </div>
                            <div>
                                <div
                                    class="text-gray-700 font-medium mr-2 text-right"
                                >
                                    Note
                                </div>
                                <div class="flex items-center">
                                    <div
                                        class="text-gray-600 font-medium text-right"
                                    >
                                        {{ bouteille.note }}%({{
                                            bouteille.nbr_notes
                                        }}
                                        avis)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto">
                        <div class="pb-2 px-4 font-sans">
                            <div class="flex justify-center">
                                <button
                                    @click="supprimerBouteille(bouteille.id)"
                                    class="bg-vin_rouge rounded-md w-full text-sm text-vin_blanc hover:text-white focus:outline-none px-2 py-2"
                                >
                                    supprimer
                                </button>
                            </div>
                            <div class="my-2"></div>

                        </div>
                    </div>
                </div>
            </div>

       <router-link
                    to="/ajouter-bouteille"

                >

      <div class="fixed bottom-0 right-0 mb-8 mr-8">
      <button class="bg-vin_blanc hover:bg-gray-700 text-white font-bold py-4 px-4 rounded-full">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
      </button>
    </div></router-link>
    </div>
</template>

<script>
import BouteilleComponent from "@/components/BouteilleComponent.vue";
import CellierDataService from "@/services/CellierDataService.js";

export default {
    components: {
        "bouteille-card": BouteilleComponent,
    },
    data() {
        return {
            bouteilles: [],
            celliers: [],
        };
    },
    mounted() {
        this.fetchBouteillesCellier();
        this.fetchCelliers();
    },
    methods: {
        async fetchBouteillesCellier() {
            try {
                const response = await CellierDataService.BouteillesCellier(1);
                this.bouteilles = response.data;
            } catch (error) {
                console.log(error);
            }
        },
        async supprimerBouteille(bouteilleId) {
            console.log(bouteilleId);
            try {
                await CellierDataService.supprimerBouteilleCellier(
                    1,
                    bouteilleId
                );
                this.bouteilles = this.bouteilles.filter(
                    (bouteille) => bouteille.id !== bouteilleId
                );
            } catch (error) {
                console.log(error);
            }
        },
        async fetchCelliers() {
            try {
                const response = await CellierDataService.getAll();
                this.celliers = response.data;
            } catch (error) {
                console.log(error);
            }
        },
    },
};
</script>
