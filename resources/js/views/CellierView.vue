<template>
    <div class="container mx-auto px-2">
        <!-- Message de succès -->
        <div v-if="estSuccessPopup" class="m-6">
            <div class="bg-green-500 text-white font-bold rounded-full px-4 py-2 flex items-center">
                <!-- Icône de succès (Google Material Icons) -->
                <span class="material-icons text-lg mr-2">check_circle</span>
                <span class="flex-1 text-center text-sm">{{
                    successMessage
                }}</span>
                <button @click="fermerPopup" class="ml-2 material-symbols-outlined">
                    <!-- Icône de fermeture (Google Material Icons) -->
                    <span> close </span>
                </button>
            </div>
        </div>
        <div class="rounded-md mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 items-center mx-2 px-2 py-4 bg-bg-rose">
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
            <!-- Ajouter cellier bloc -->
            <div v-if="showAjouterCellier" class="md:col-span-3 mt-4">
                <AjouterCellierComponent @close="showAjouterCellier = false" @nouveau-cellier="ajoutCellier" />
            </div>
            <div v-if="showModifierCellier" class="md:col-span-3 mt-4">
                <ModifierCellierComponent :cellier="cellierActif" @close="showModifierCellier = false"
                    @cellier-modifie="mettreAJourCellier" @cellier-supprime="supprimerCellier" />
            </div>
        </div>
        <!-- recherche dans le cellier -->
        <div class="flex items-center mx-auto p-2">
            <form @submit.prevent="" class="w-full">
                <label class="relative flex items-center">
                    <input v-model="rechercheCellier" type="text" class="w-full py-1 pl-2 pr-[32px] rounded"
                        placeholder="Rechercher dans le cellier" />
                    <button class="material-symbols-outlined absolute right-0 p-1" @click="rechercheBouteillesCellier">
                        search
                    </button>
                </label>
            </form>
        </div>
        <div v-if="cellierActif.id === 0" class="w-full flex flex-col items-center justify-center h-full">
            <p>
                Vous n'avez pas encore enregistré de cellier. Pour commencer,
                cliquez sur le bouton ci-dessous pour ajouter un nouveau
                cellier.
            </p>
            <button class="material-symbols-outlined w-9 px-2 py-1 font-semibold text-vin-rouge text-center"
                @click="handleAddButton">
                add
            </button>
            <p>
                Vous pourrez ensuite ajouter vos vins préférés et commencer à
                les suivre facilement
            </p>
        </div>


        <div v-else>

            <div v-if="bouteillesAffiches && bouteillesAffiches.length > 0">
                <!-- Section pour filtre et tri -->
                <div class="md:col-span-2 flex justify-between items-center">
                    <button class="mr-auto rounded pt-1 pb-1 pl-1 pr-10" @click="estOuvertFiltre = !estOuvertFiltre">
                        <span class="material-symbols-outlined text-4xl font-medium text-vin-rouge">tune</span>
                    </button>
                    <transition enter-active-class="transition duration-500 ease-in-out transform"
                        enter-from-class="-translate-x-full" enter-to-class="translate-x-0"
                        leave-active-class="transition duration-500 ease-in-out transform" leave-from-class="translate-x-0"
                        leave-to-class="-translate-x-full">
                        <FiltreComponent v-if="estOuvertFiltre" @filtrer-bouteilles="filtrerBouteilles"
                            @fermer-filtre="fermerFiltre" :bouteilles="bouteilles"
                            class="w-full fixed inset-0 mb-15 z-50" />
                    </transition>
                    <button class="rounded" @click="reinitialisationBouteilles();
                    rotation();

                                            ">

                        <span class="material-symbols-outlined text-4xl font-medium text-vin-rouge pr-1" :class="
                            {
                                'rotate-[360deg] ease-in-out duration-500':
                                estRotation,

                                                                                                                            }

                        ">
                            refresh
                        </span>
                    </button>

                    <button class="rounded" @click=" triCellier(); rotationTri(); ">
                        <span
                            class="material-symbols-outlined text-4xl font-medium text-vin-rouge pr-1 ease-in-out duration-500"
                            :class=" { '-scale-y-100': est180 } ">
                            swap_vert

                        </span>
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 h-full">
                    <BouteilleComponent :bouteilles=" bouteillesAffiches " :cellierId=" cellierActif.id "
                        @bouteille-supprime=" supprimerBouteille " @bouteille-modifie=" modifierBouteille " />
                </div>
            </div>
            <div v-else class="w-full flex flex-col items-center justify-center h-full">
                <p>
                    Félicitations, votre cellier a été ajouté avec succès ! Pour
                    commencer à suivre vos bouteilles de vin, vous pouvez
                    ajouter une bouteille dès maintenant en cliquant sur le
                    bouton Plus(+) ci-dessous
                </p>
            </div>
        </div>

        <router-link :to="
            {
                name: 'ajouter-bouteille',
                    params: { cellierId: cellierActif.id },
            }
        ">
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
import ModifierCellierComponent from "@/components/ModifierCellierComponent.vue";
import { mapMutations } from "vuex";
export default {
    components: {
        BouteilleComponent,
        FiltreComponent,
        AjouterCellierComponent,
        ModifierCellierComponent,
    },

    data () {
        return {
            bouteilles: [],
            filteredBouteilles: [],
            celliers: [],
            cellierActif: { id: 0, nom: "Aucun cellier" },
            showAjouterCellier: false,
            estOuvertFiltre: false,
            rechercheCellier: "",
            showModifierCellier: false,
            estAjouterCellier: false,
            estPopupOuvert: false,
            estRotation: false,
            bouteilleSuprimeeMessage: "",
            est180: false,
        };
    },
    async mounted () {
        await this.fetchCelliers();
        if (this.cellierActif.id !== 0) {
            await this.fetchBouteillesCellier();
        }

        console.log(this.message);
    },
    computed: {
        bouteillesAffiches () {
            return this.filteredBouteilles.length > 0
                ? this.filteredBouteilles
                : this.bouteilles;
        },

        successMessage () {
            const message =
                this.$route.query.message || this.bouteilleSuprimeeMessage;

            if (message && message !== "") {
                this.showSuccessPopup();
            }

            return message;
        },
        estSuccessPopup () {
            return this.successMessage !== "" && this.estPopupOuvert;
        },
        // ...mapGetters({ cellierFiltreValeurs: "cellierFiltreValeurs" }),
    },
    watch: {
        successMessage (newVal) {
            if (newVal !== "") {
                this.showSuccessPopup();
            }
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

            // Réinitialiser les filtres et tris au changement du cellier
            this.reinitialisationBouteilles();
        },
        async fetchBouteillesCellier () {
            try {
                const response =
                    await BouteilleDataService.getBouteillesByCellierId(
                        this.cellierActif.id
                    );
                this.bouteilles = response.data.bouteilles;
                console.log(this.cellierActif);
            } catch (error) {
                console.log(error);
            }
        },
        async supprimerBouteille (bouteille) {
            const estConfirmé = confirm(
                "Êtes-vous sûr de vouloir supprimer cette bouteille ?"
            );
            if (estConfirmé) {
                try {
                    await BouteilleDataService.supprimerBouteilleDansCellier(
                        this.cellierActif.id,
                        bouteille.id
                    );
                    this.bouteilles = this.bouteilles.filter(
                        (bouteilleItem) => bouteilleItem.id !== bouteille.id
                    );

                    // initier le message de confirmation
                    this.bouteilleSuprimeeMessage =
                        "La bouteille a été supprimée avec succès.";

                    // Montrer le message de confirmation
                    this.showSuccessPopup();
                } catch (error) {
                    console.log(error);
                }
            }
        },

        // Obtenir la liste des celliers
        async fetchCelliers () {
            try {
                const response = await CellierDataService.getAll();
                this.celliers = response.data;
                // Si il est existe au moins un cellier, on mis le premier comme cellier actif
                if (this.celliers.length > 0) {
                    this.cellierActif = this.celliers[0];
                }
            } catch (error) {
                console.log(error);
            }
        },
        //Animation du bouton de réinitialisation
        rotation () {
            this.estRotation = true;
            setTimeout(() => {
                this.estRotation = false;
            }, 500);
        },

        //Animation du bouton de tri
        rotationTri () {
            this.est180 = !this.est180
        },

        //Applique le résultat de la recherche avec les filtres ou non dans le celliers
        rechercheBouteillesCellier () {
            try {
                console.log(this.bouteilles);
                if (this.filteredBouteilles.length > 0) {
                    this.filteredBouteilles = this.filteredBouteilles.filter(
                        (bouteille) => {
                            return (
                                bouteille.nom
                                    .toLowerCase()
                                    .includes(
                                        this.rechercheCellier.toLowerCase()
                                    ) ||
                                bouteille.pays.nom
                                    .toLowerCase()
                                    .includes(
                                        this.rechercheCellier.toLowerCase()
                                    )
                            );
                        }
                    );
                } else {
                    this.bouteilles = this.bouteilles.filter((bouteille) => {
                        return (
                            bouteille.nom
                                .toLowerCase()
                                .includes(
                                    this.rechercheCellier.toLowerCase()
                                ) ||
                            bouteille.pays.nom
                                .toLowerCase()
                                .includes(this.rechercheCellier.toLowerCase())
                        );
                    });
                }
            } catch (error) {
                console.log(error);
            }
        },
        async ajoutCellier (nouveaucellier) {
            this.celliers.push(nouveaucellier);
            console.log(this.celliers);
        },
        handleAddButton () {
            this.showModifierCellier = false;
            this.showAjouterCellier = true;
            this.estAjouterCellier = !this.estAjouterCellier;
        },
        handleEditButton () {
            this.showAjouterCellier = false;
            this.showModifierCellier = true;
        },
        mettreAJourCellier (cellierModifie) {
            this.celliers = this.celliers.map((cellier) => {
                if (cellier.id === cellierModifie.id) {
                    return cellierModifie;
                } else {
                    return cellier;
                }
            });

            if (
                this.cellierActif &&
                this.cellierActif.id === cellierModifie.id
            ) {
                this.cellierActif = cellierModifie;
            }

            this.cellierSelectionne = null;
        },
        supprimerCellier () {
            this.celliers = this.celliers.filter(
                (c) => c.id !== this.cellierActif.id
            );

            // Filtrer les bouteilles qui ne sont pas associées au cellier supprimé
            console.log(this.bouteilles);
            this.bouteilles = this.bouteilles.filter(
                (b) => b.cellier.id !== this.cellierActif.id
            );

            this.cellierActif = this.celliers[0];

            // Mettre à jour les bouteilles affichées
            this.bouteillesAffiches();
        },
        triCellier () {
            if (this.filteredBouteilles.length > 0) {
                this.filteredBouteilles.reverse();
            } else {
                this.bouteilles.reverse();
            }
        },
        async reinitialisationBouteilles () {
            await this.fetchBouteillesCellier();
            if (this.filteredBouteilles.length > 0) {
                this.filteredBouteilles = [];
            }
            // Mettre à jour les valeurs du filtre
            this.setCellierFiltreValeurs({});
        },
        showSuccessPopup () {
            this.estPopupOuvert = true;
            setTimeout(() => {
                this.estPopupOuvert = false;
                this.$router.replace({
                    query: { ...this.$route.query, message: "" },
                });
                this.bouteilleSuprimeeMessage = "";
            }, 3000);
        },
        fermerPopup () {
            this.estPopupOuvert = false;
        },

        ...mapMutations(["setCellierFiltreValeurs"]),
    },
};
</script>
