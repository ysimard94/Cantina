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
                    <button class="material-symbols-outlined w-9 px-2 py-1 font-semibold text-vin-rouge"
                        @click="handleEditButton">
                        edit
                    </button>
                    <button class="material-symbols-outlined w-9 px-2 py-1 font-semibold text-vin-rouge"
                        @click="handleAddButton">
                        add
                    </button>
                </div>
            </div>
            <div v-if="showAjouterCellier" class="md:col-span-3 mt-4">
                <AjouterCellierComponent @close="showAjouterCellier = false" @nouveau-cellier="ajoutCellier" />
            </div>
            <div v-if="showModifierCellier" class="md:col-span-3 mt-4">
                <ModifierCellierComponent :cellier="cellierActif" @close="showModifierCellier = false"
                    @cellier-modifie="mettreAJourCellier" @cellier-supprime="supprimerCellier" />
            </div>
        </div>


        <!--     <div class="flex items-center mx-auto p-2">
            <form @submit.prevent="" class="w-full">
                <label for="rechercheCellier" class="relative">
                    <input type="text" id="rechercheCellier" v-model="rechercheCellier"
                        class="w-full rounded pt-2 pb-2 pl-1 pr-10" placeholder="Rechercher dans le cellier" />
                    <button class="absolute right-0 pl-2" @click=""><span
                            class="material-symbols-outlined text-4xl font-medium">
                            search
                        </span></button>
                </label>
            </form>
        </div>-->

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

            <BouteilleComponent v-if="bouteillesAffiches && bouteillesAffiches.length > 0" :bouteilles="bouteillesAffiches" />
            <div v-else class="flex items-center justify-center h-full">
                <p class="text-gray-500">Aucune bouteille dans ce cellier.</p>
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
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6">
                        </path>
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
import ModifierCellierComponent from "@/components/ModifierCellierComponent.vue";


export default {
    components: {
        BouteilleComponent,
        FiltreComponent,
        AjouterCellierComponent,
        ModifierCellierComponent,
    },
    data() {
        return {
            bouteilles: [],
            filteredBouteilles: [],
            celliers: [],
            cellierActif: { id: 0, nom: "Aucun cellier" },
            showAjouterCellier: false,
            estOuvertFiltre: false,
            showModifierCellier: false
        };
    },
    async mounted() {
        await this.fetchCelliers();
        await this.fetchBouteillesCellier();
    },
    computed: {
        bouteillesAffiches() {
            return this.filteredBouteilles.length > 0
                ? this.filteredBouteilles
                : this.bouteilles;
        },
    },
    methods: {
        // Appliquer le filtre pour afficher toutes les bouteilles filtrées
        filtrerBouteilles(filteredBouteilles) {
            this.filteredBouteilles = filteredBouteilles;
        },
        montrerFiltre() {
            this.estOuvertFiltre = true;
        },
        fermerFiltre() {
            this.estOuvertFiltre = false;
        },
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
                console.log(this.cellierActif)
            } catch (error) {
                console.log(error);
            }
        },
        async supprimerBouteille(bouteilleId) {
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
                console.log(this.cellierActif)
            } catch (error) {
                console.log(error);
            }
        },

        async ajoutCellier(nouveaucellier) {
            this.celliers.push(nouveaucellier);

            console.log(this.celliers)

        },
        handleAddButton() {
            this.showModifierCellier = false;
            this.showAjouterCellier = true;
        },
        handleEditButton() {
            this.showAjouterCellier = false;
            this.showModifierCellier = true;
        },
        mettreAJourCellier(cellierModifie) {
            this.celliers = this.celliers.map((cellier) => {
                if (cellier.id === cellierModifie.id) {
                    return cellierModifie;
                } else {
                    return cellier;
                }
            });


            if (this.cellierActif && this.cellierActif.id === cellierModifie.id) {
                this.cellierActif = cellierModifie;
            }

            this.cellierSelectionne = null;
        },
        supprimerCellier() {
            this.celliers = this.celliers.filter(
                (c) => c.id !== this.cellierActif.id
            );
            this.cellierActif = this.celliers[0];
            this.afficherBouteilles();
        }
    }
};
</script>
