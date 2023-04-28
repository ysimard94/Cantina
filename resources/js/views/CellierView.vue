<template>
    <div class="container mx-auto px-2">
        <div class="flex items-center mx-auto px-2">
            <FiltreComponent :bouteilles="bouteilles" />
            <label for="select-cellier" class="mr-4 font-medium text-gray-700"
                >celliers</label
            >
            <select
                id="select-cellier"
                @change="handleChangerCellier"
                v-model="cellierActif"
                class="mr-2 p-2 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            >
                <option disabled>-- Sélectionner un cellier --</option>
                <option
                    v-for="(cellier, index) in celliers"
                    :key="index"
                    :value="cellier"
                >
                    {{ cellier.nom }}
                </option>
            </select>
            <router-link
                :to="{
                    name: 'modifier-cellier',
                    params: { id: cellierActif.id },
                }"
            >
                <button
                    class="w-9 px-2 py-1 rounded-md bg-vin_rouge text-white hover:bg-vin_blanc focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    <svg
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"
                        ></path>
                    </svg>
                </button>
            </router-link>
            <router-link to="/ajouter-cellier/">
                <button
                    class="w-9 px-2 py-1 rounded-md bg-vin_rouge text-white hover:bg-vin_blanc focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mx-2"
                >
                    <svg
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                        ></path>
                    </svg>
                </button>
            </router-link>
        </div>
        <div class="flex items-center mx-auto p-2">
            <form @submit.prevent="" class="w-full">
                <label for="rechercheCellier" class="relative">
                    <input
                        type="text"
                        id="rechercheCellier"
                        v-model="rechercheCellier"
                        class="w-full rounded pt-2 pb-2 pl-1 pr-1"
                        placeholder="Rechercher dans le cellier"
                    />
                    <span class="absolute right-0" @click=""
                        ><img
                            src="@assets/search_FILL1_wght400_GRAD0_opsz40.svg"
                            alt="Recherche"
                    /></span>
                </label>
            </form>
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
            :to="{
                name: 'ajouter-bouteille',
                params: { cellierId: cellierActif.id },
            }"
        >
            <div class="fixed bottom-0 right-0 mb-8 mr-8">
                <button
                    class="bg-vin_blanc hover:bg-gray-700 text-white font-bold py-4 px-4 rounded-full"
                >
                    <svg
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                        ></path>
                    </svg>
                </button>
            </div>
        </router-link>
    </div>
</template>

<script>
import BouteilleComponent from "@/components/BouteilleComponent.vue";
import FiltreComponent from "@/components/FiltreComponent.vue";

import BouteilleDataService from "@/services/BouteilleDataService.js";
import CellierDataService from "@/services/CellierDataService.js";

export default {
    components: {
        "bouteille-card": BouteilleComponent,
        FiltreComponent,
    },
    data() {
        return {
            bouteilles: [],
            celliers: [],
            cellierActif: { id: 0, nom: "Aucun cellier" },
        };
    },
    async mounted() {
        await this.fetchCelliers();
        await this.fetchBouteillesCellier();
    },
    methods: {
        handleChangerCellier() {
            this.fetchBouteillesCellier();
        },
        async fetchBouteillesCellier() {
            try {
                const response =
                    await BouteilleDataService.getBouteillesByCellierId(
                        this.cellierActif.id
                    );
                this.bouteilles = response.data.bouteilles;
                console.log(this.bouteilles);
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
                this.cellierActif = this.celliers[0];
            } catch (error) {
                console.log(error);
            }
        },
    },
};
</script>
