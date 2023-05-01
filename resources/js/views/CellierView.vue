<template>
    <div class="container mx-auto px-2">
        <div class="rounded-md mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 items-center mx-2 px-2 py-4 bg-bg-rose">
            <label for="select-cellier" class="md:col-span-1 font-medium text-gray-700 text-left">Mes celliers</label>
            <div class="md:col-span-2 flex justify-between items-center">
                <select id="select-cellier" @change="handleChangerCellier" v-model="cellierActif"
                    class="mr-2 p-2 font-semibold w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option disabled>-- Sélectionner un cellier --</option>
                    <option v-for="(cellier, index) in celliers" :key="index" :value="cellier">
                        {{ cellier.nom }}
                    </option>
                </select>
                <div class="flex">
                    <router-link :to="{
                            name: 'modifier-cellier',
                            params: { id: cellierActif.id },
                        }">
                        <button class="material-symbols-outlined w-9 px-2 py-1 font-semibold text-vin-blanc"
                            @click="showAjouterCellier = true">
                            edit
                        </button>
                    </router-link>

                    <button class="material-symbols-outlined w-9 px-2 py-1 font-semibold text-vin-rouge"
                        @click="showAjouterCellier = true">
                        add
                    </button>
                </div>
            </div>
            <div v-if="showAjouterCellier" class="md:col-span-3 mt-4">
                <AjouterCellierComponent @close="showAjouterCellier = false" />
            </div>
        </div>
        <div class="flex items-center mx-auto p-2">
            <form @submit.prevent="" class="w-full">
                <label for="rechercheCellier" class="relative">
                    <input type="text" id="rechercheCellier" v-model="rechercheCellier"
                        class="w-full rounded pt-2 pb-2 pl-1 pr-10" placeholder="Rechercher dans le cellier" />
                    <buttons class="absolute right-0 pl-2" @click="rechercheBouteillesCellier"><span
                            class="material-symbols-outlined text-4xl font-medium">
                            search
                        </span></buttons>
                </label>
            </form>
        </div>

        <!-- Section pour filtre et tri -->
        <div class="md:col-span-2 flex flex-col justify-between items-center">
            <button class="mr-auto rounded pt-2 pb-2 pl-1 pr-10" @click="estOuvertFiltre = !estOuvertFiltre">
                <span class="material-symbols-outlined text-4xl font-medium">tune</span>
            </button>
            <transition enter-active-class="transition duration-500 ease-in-out transform"
                enter-from-class="-translate-x-full" enter-to-class="translate-x-0"
                leave-active-class="transition duration-500 ease-in-out transform" leave-from-class="translate-x-0"
                leave-to-class="-translate-x-full">
                <FiltreComponent v-if="estOuvertFiltre" @filtrer-bouteilles="filtrerBouteilles"
                    @fermer-filtre="fermerFiltre" :bouteilles="bouteilles" class="w-full fixed inset-0 mb-15 z-50" />
            </transition>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8 h-full">
            <div class="bg-bg_rose flex flex-col overflow-hidden shadow rounded-lg py-2 m-2 h-full"
                v-for=" bouteille  in bouteillesAffiches" :key="bouteille.id">
                <img :src="bouteille.photo" :alt="bouteille.nom" class="w-1/3 mx-auto" />
                <div class="px-4 pt-4 flex flex-col justify-between">
                    <h4 class="text-lg font-serif font-semibold text-vin-rouge text-left h-[67px] leading-tight">
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
                            <div class="text-gray-700 font-medium mr-2 text-right">
                                Note
                            </div>
                            <div class="flex items-center">
                                <div class="text-gray-600 font-medium text-right">
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
                            <button @click="supprimerBouteille(bouteille.id)"
                                class="bg-vin_rouge rounded-md w-full text-sm text-vin_blanc hover:text-white focus:outline-none px-2 py-2">
                                supprimer
                            </button>
                        </div>
                        <div class="my-2"></div>
                    </div>
                </div>
            </div>
        </div>

        <router-link :to="{
                    name: 'ajouter-bouteille',
                    params: { cellierId: cellierActif.id },
                }">
            <div class="fixed bottom-[72px] right-0 mb-8 mr-8">
                <button class="bg-vin_blanc hover:bg-gray-700 text-white font-bold py-4 px-4 rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
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
import AjouterCellierComponent from "@/components/AjouterCellierComponent.vue";

export default {
    components: {
        "bouteille-card": BouteilleComponent,
        FiltreComponent,
        AjouterCellierComponent,
    },
    data () {
        return {
            bouteilles: [],
            filteredBouteilles: [],
            celliers: [],
            cellierActif: { id: 0, nom: "Aucun cellier" },
            showAjouterCellier: false,
            estOuvertFiltre: false,
            rechercheCellier: '',
        };
    },
    async mounted () {
        await this.fetchCelliers();
        await this.fetchBouteillesCellier();
    },
    computed: {
        bouteillesAffiches () {
            return this.filteredBouteilles.length > 0
                ? this.filteredBouteilles
                : this.bouteilles;
        },
    },
    methods: {
        // Appliquer le filtre pour afficher toutes les bouteilles filtrées
        filtrerBouteilles (filteredBouteilles) {
            this.filteredBouteilles = filteredBouteilles;
        },
        montrerFiltre () {
            this.estOuvertFiltre = true;
        },
        fermerFiltre () {
            this.estOuvertFiltre = false;
        },
        handleChangerCellier () {
            this.fetchBouteillesCellier();
        },
        async fetchBouteillesCellier () {
            try {
                const response =
                    await BouteilleDataService.getBouteillesByCellierId(
                        this.cellierActif.id
                    );
                this.bouteilles = response.data.bouteilles;
            } catch (error) {
                console.log(error);
            }
        },
        async supprimerBouteille (bouteilleId) {
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
        async fetchCelliers () {
            try {
                const response = await CellierDataService.getAll();
                this.celliers = response.data;
                this.cellierActif = this.celliers[0];
            } catch (error) {
                console.log(error);
            }
        },
        //Applique le résultat de la recherche avec les filtres ou non dans le celliers
        rechercheBouteillesCellier () {
            try {
                console.log(this.bouteilles)
                if (this.filteredBouteilles.length > 0) {
                    this.filteredBouteilles = this.filteredBouteilles.filter(bouteille => {
                        return bouteille.nom.toLowerCase().includes(this.rechercheCellier.toLowerCase()) || bouteille.pays.nom.toLowerCase().includes(this.rechercheCellier.toLowerCase())
                    })
                } else {
                    this.bouteilles = this.bouteilles.filter(bouteille => {
                        return bouteille.nom.toLowerCase().includes(this.rechercheCellier.toLowerCase()) || bouteille.pays.nom.toLowerCase().includes(this.rechercheCellier.toLowerCase())
                    })

                }
            } catch (error) {
                console.log(error)
            }
        }
    },
};
</script>
