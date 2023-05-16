<template>
    <div class="container mx-auto px-2">
        <transition
            enter-active-class="transition duration-300 ease-out opacity-0"
            enter-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-300 ease-in opacity-100"
            leave-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <!-- Message de succès -->
            <div v-if="estSuccessPopup" class="m-6">
                <div
                    class="bg-green-500 text-white font-bold rounded-full px-4 py-2 flex items-center"
                >
                    <!-- Icône de succès (Google Material Icons) -->
                    <span class="material-icons text-lg mr-2"
                        >check_circle</span
                    >
                    <span class="flex-1 text-center text-sm">{{
                        successMessage
                    }}</span>
                    <button
                        @click="fermerPopup"
                        class="ml-2 material-symbols-outlined"
                    >
                        <!-- Icône de fermeture (Google Material Icons) -->
                        <span> close </span>
                    </button>
                </div>
            </div>
        </transition>

        <div
            class="rounded-md mt-4 grid grid-cols-1 md:grid-cols-3 gap-1 items-center mx-2 px-2 py-4 bg-bg-rose"
        >
            <div class="md:col-span-2 flex justify-between items-center">
                <select
                    id="select-cellier"
                    @change="handleChangerCellier"
                    v-model="cellierActif"
                    class="p-2 font-sans w-full mr-2 rounded-md shadow-sm bg-slate-100 border-gray-300 border-2 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                >
                    <option disabled :selected="cellierActif.id === 0">
                        {{
                            celliers.length === 0
                                ? "-- Aucun cellier --"
                                : "-- Sélectionner un cellier --"
                        }}
                    </option>
                    <option
                        v-for="(cellier, index) in celliers"
                        :key="index"
                        :value="cellier"
                    >
                        {{ cellier.nom }}
                    </option>
                </select>
                <div class="flex">
                    <button
                        v-if="cellierActif.id !== 0"
                        class="material-symbols-outlined w-9 px-2 py-1 font-semibold text-vin-rouge"
                        @click="handleEditButton"
                    >
                        edit
                    </button>
                    <button
                        class="rounded-full text-4xl material-symbols-outlined px-1 py-1 font-semibold text-vin-rouge transition-transform duration-300 transform origin-center"
                        :class="{ 'rotate-45': showAjouterCellier }"
                        @click="handleAddButton"
                    >
                        add
                    </button>
                </div>
            </div>
            <!-- Ajouter cellier bloc -->
            <div v-if="showAjouterCellier" class="md:col-span-3 mt-4">
                <AjouterCellierComponent
                    @close="showAjouterCellier = false"
                    @nouveau-cellier="ajoutCellier"
                    :cellierActif="cellierActif"
                    :celliers="celliers"
                />
            </div>
            <div v-if="showModifierCellier" class="md:col-span-3 mt-4">
                <ModifierCellierComponent
                    :cellier="cellierActif"
                    :celliers="celliers"
                    @close="showModifierCellier = false"
                    @cellier-modifie="mettreAJourCellier"
                    @cellier-supprime="supprimerCellier"
                />
            </div>
        </div>
        <!-- recherche dans le cellier -->
        <div class="flex items-center mx-auto p-2 mt-1">
            <form @submit.prevent="" class="w-full">
                <label class="relative flex items-center">
                    <input
                        v-model="rechercheCellier"
                        type="text"
                        class="w-full py-1 pl-2 pr-[32px] rounded"
                        placeholder="Rechercher dans le cellier"
                    />
                    <button
                        class="material-symbols-outlined absolute right-0 p-1"
                        @click="rechercheBouteillesCellier"
                    >
                        search
                    </button>
                </label>
            </form>
        </div>
        <div
            v-if="cellierActif.id === 0"
            class="w-full flex flex-col items-center justify-center h-full"
        >
            <p>
                Vous n'avez pas encore enregistré de cellier. Pour commencer,
                cliquez sur le bouton ci-dessous pour ajouter un nouveau
                cellier.
            </p>
            <button
                class="material-symbols-outlined w-9 px-2 py-1 font-semibold text-vin-rouge text-center"
                @click="handleAddButton"
            >
                add
            </button>
            <p>
                Vous pourrez ensuite ajouter vos vins préférés et commencer à
                les suivre facilement
            </p>
        </div>

        <div v-else>
            <div v-show="estSHow">
                <!-- Section pour filtre et tri -->
                <div class="md:col-span-2 flex justify-between items-center">
                    <button
                        class="mr-auto rounded pt-1 pb-1 pl-1 pr-10"
                        @click="estOuvertFiltre = !estOuvertFiltre"
                    >
                        <span
                            class="material-symbols-outlined text-4xl font-medium text-vin-rouge"
                            >tune</span
                        >
                    </button>
                    <transition
                        enter-active-class="transition duration-500 ease-in-out transform"
                        enter-from-class="-translate-x-full"
                        enter-to-class="translate-x-0"
                        leave-active-class="transition duration-500 ease-in-out transform"
                        leave-from-class="translate-x-0"
                        leave-to-class="-translate-x-full"
                    >
                        <FiltreComponent
                            v-if="estOuvertFiltre"
                            @filtrer-bouteilles="filtrerBouteilles"
                            @fermer-filtre="fermerFiltre"
                            :bouteilles="bouteilles"
                            parent="cellier"
                            class="w-full fixed inset-0 mb-15 z-50"
                        />
                    </transition>
                    <button
                        class="rounded"
                        @click="
                            reinitialisationBouteilles();
                            rotation();
                        "
                    >
                        <span
                            class="material-symbols-outlined text-4xl font-medium text-vin-rouge pr-1"
                            :class="{
                                'rotate-[360deg] ease-in-out duration-500':
                                    estRotation,
                            }"
                        >
                            refresh
                        </span>
                    </button>

                    <button
                        class="rounded"
                        @click="
                            triCellier();
                            rotationTri();
                        "
                    >
                        <span
                            class="material-symbols-outlined text-4xl font-medium text-vin-rouge pr-1 ease-in-out duration-500"
                            :class="{ '-scale-y-100': est180 }"
                        >
                            swap_vert
                        </span>
                    </button>
                </div>

                <div
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 h-full"
                >
                    <BouteilleComponent
                        :bouteilles="bouteillesAffiches"
                        :cellierId="cellierActif.id"
                        @bouteille-supprime="supprimerBouteille"
                    />
                </div>
            </div>
            <div
                v-show="!estSHow"
                class="w-full flex flex-col items-center justify-center h-full mt-4"
            >
                <p>
                    Félicitations, votre cellier a été ajouté avec succès ! Pour
                    commencer à suivre vos bouteilles de vin, vous pouvez
                    ajouter une bouteille dès maintenant en cliquant sur le
                    bouton Plus(+) ci-dessous
                </p>
            </div>
        </div>
        <!-- Modale d'ajout d'avis -->
        <div
            v-if="afficheModale"
            class="bg-zinc-950/25 fixed right-0 left-0 top-0 bottom-0 z-10"
        ></div>
        <dialog
            v-show="afficheModale"
            class="bg-bg-rose mx-2 rounded z-20 fixed inset-0 flex items-center justify-center"
        >
            <form @submit.prevent="sendAvis()">
                <div class="flex flex-row-reverse">
                    <span
                        class="material-symbols-outlined text-3xl"
                        @click="fermerModale()"
                    >
                        close
                    </span>
                </div>
                <h3 class="text-m">
                    Vous avez aimé la bouteille ? Laissez une note et un
                    commentaire !
                </h3>
                <div class="flex text-left mt-4">
                    <div v-for="i in 5" :key="i" class="mr-2">
                        <svg
                            @click="note = i"
                            :class="{ 'text-vin-blanc': note >= i }"
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-8 w-8 cursor-pointer"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                        >
                            <path
                                d="M12 2 L15.09 8.09 L23 9.54 L17.91 15.5 L19.64 23.54 L12 20.59 L4.36 23.54 L6.09 15.5 L1 9.54 L8.91 8.09 L12 2 Z"
                            />
                        </svg>
                    </div>
                </div>
                <div class="flex flex-col text-left mt-4">
                    <label for="commentaire">Commentaire</label>
                    <textarea
                        v-model="commentaire"
                        id="commentaire"
                        class="mt-2 p-1 rounded"
                        rows="4"
                    ></textarea>
                </div>
                <div class="flex flex-row-reverse mt-4">
                    <button type="submit">
                        <span
                            class="material-symbols-outlined w-14 h-10 rounded-lg text-white font-semibold bg-vin-rouge flex items-center justify-center"
                        >
                            send
                        </span>
                    </button>
                </div>
            </form>
        </dialog>
    </div>
</template>

<script>
import BouteilleComponent from "@/components/BouteilleComponent.vue";
import FiltreComponent from "@/components/FiltreComponent.vue";
import BouteilleDataService from "@/services/BouteilleDataService.js";
import AvisDataService from "@/services/AvisDataService.js";
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

    data() {
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
            estSHow: false,
            estConfirmé: false,
            note: 0,
            commentaire: "",
            afficheModale: false,
            bouteilleASupprimer: [],
        };
    },
    async mounted() {
        await this.fetchCelliers();
        if (this.$store.getters.cellierActif) {
            this.cellierActif = this.$store.getters.cellierActif;
        } else if (this.celliers.length > 0) {
            this.cellierActif = this.celliers[0];
        } else {
            this.cellierActif = { id: 0, nom: "Aucun cellier" };
        }

        if (this.cellierActif.id !== 0) {
            await this.fetchBouteillesCellier();
        }
    },
    computed: {
        bouteillesAffiches() {
            return this.filteredBouteilles.length > 0
                ? this.filteredBouteilles
                : this.bouteilles;
        },

        successMessage() {
            const message =
                this.$route.query.message || this.bouteilleSuprimeeMessage;

            if (message && message !== "") {
                this.showSuccessPopup();
            }

            return message;
        },
        estSuccessPopup() {
            return this.successMessage !== "" && this.estPopupOuvert;
        },
        estSHow() {
            return (
                this.bouteillesAffiches && this.bouteillesAffiches.length > 0
            );
        },
    },
    watch: {
        successMessage(newVal) {
            if (newVal !== "") {
                this.showSuccessPopup();
            }
        },
    },
    methods: {
        // Appliquer le filtre pour afficher toutes les bouteilles filtrées
        filtrerBouteilles(filteredBouteilles) {
            this.filteredBouteilles = filteredBouteilles;
        },

        // Montrer le filtre
        montrerFiltre() {
            this.estOuvertFiltre = true;
        },

        // fermer le filtre
        fermerFiltre() {
            this.estOuvertFiltre = false;
        },

        // Réinitialiser les filtres et tris au changement du cellier
        handleChangerCellier() {
            this.fetchBouteillesCellier();
            this.setCellierActif(this.cellierActif);
            // Réinitialiser les filtres et tris au changement du cellier
            this.reinitialisationBouteilles();
        },

        // Obtenir tous les bouteilles du cellier actif
        async fetchBouteillesCellier() {
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
        //ouvrir et fermer la modale, fermer renvoie la bouteille à supprimer vers la fonction supprimerBouteille
        ouvrirModale() {
            this.afficheModale = true;
        },
        fermerModale() {
            this.estConfirmé = true;
            this.afficheModale = false;

            this.supprimerBouteille(this.bouteilleASupprimer);
        },
        //fait apparaître une modale puis supprimer une bouteille dans le cellier actif puis l'archiver
        async supprimerBouteille(bouteille) {
            if (!this.estConfirmé) {
                this.bouteilleASupprimer = bouteille;
                this.ouvrirModale();
            } else if (this.estConfirmé) {
                try {
                    // Supprimer la bouteille du cellier
                    const response =
                        await BouteilleDataService.supprimerBouteilleDansCellier(
                            this.cellierActif.id,
                            bouteille.id
                        );

                    this.bouteilles = this.bouteilles.map((bouteilleItem) => {
                        if (bouteilleItem.id === bouteille.id) {
                            // Mettre à jour la quantité de la bouteille
                            bouteilleItem.pivot.quantite =
                                response.data.quantite;
                        }
                        return bouteilleItem;
                    });
                    this.bouteilles = this.bouteilles.filter(
                        (bouteilleItem) => bouteilleItem.pivot.quantite !== 0
                    );

                    // Archiver la bouteille

                    await BouteilleDataService.archiverBouteille(
                        this.cellierActif.id,
                        bouteille.id
                    );

                    // initier le message de confirmation
                    this.bouteilleSuprimeeMessage =
                        "La bouteille a été archivé avec succès.";

                    // Montrer le message de confirmation
                    this.showSuccessPopup();
                    this.bouteilleASupprimer = [];
                    this.estConfirmé = false;
                    this.note = 0;
                    this.commentaire = "";
                } catch (error) {
                    console.log(error);
                } finally {
                }
            }
        },

        async sendAvis() {
            try {
                await AvisDataService.sendAvisBouteille({
                    bouteille_id: this.bouteilleASupprimer.id,
                    utilisateur_id: this.$store.getters.session.utilisateur_id,
                    note: this.note,
                    commentaire: this.commentaire,
                });
                this.estConfirmé = true;
                this.afficheModale = false;
                this.supprimerBouteille(this.bouteilleASupprimer);
            } catch (error) {
                console.log(error);
            }
        },

        // Obtenir la liste des celliers
        async fetchCelliers() {
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
        rotation() {
            this.estRotation = true;
            setTimeout(() => {
                this.estRotation = false;
            }, 500);
        },

        //Animation du bouton de tri
        rotationTri() {
            this.est180 = !this.est180;
        },

        //Applique le résultat de la recherche avec les filtres ou non dans le celliers
        rechercheBouteillesCellier() {
            try {
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
        async ajoutCellier(nouveaucellier) {
            this.cellierActif = nouveaucellier; // mettre à jour le cellierActif avec le nouveau cellier
            this.celliers.push(nouveaucellier); // ajouter le nouveau cellier à la liste des celliers
            await this.fetchBouteillesCellier();
        },
        handleAddButton() {
            this.showModifierCellier = false;
            this.showAjouterCellier = !this.showAjouterCellier;
            this.estAjouterCellier = !this.estAjouterCellier;
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

            if (
                this.cellierActif &&
                this.cellierActif.id === cellierModifie.id
            ) {
                this.cellierActif = cellierModifie;
            }

            this.cellierSelectionne = null;
        },
        async supprimerCellier() {
            this.celliers = this.celliers.filter(
                (c) => c.id !== this.cellierActif.id
            );

            if (this.celliers.length > 0) {
                this.cellierActif = this.celliers[0];

                // Mettre à jour les bouteilles affichées
                await this.fetchBouteillesCellier();
                // Mettre à jour les bouteilles affichées
                this.filteredBouteilles = this.bouteillesAffiches;
            } else {
                this.cellierActif = { id: 0, nom: "Aucun cellier" };
            }
        },
        triCellier() {
            if (this.filteredBouteilles.length > 0) {
                this.filteredBouteilles.reverse();
            } else {
                this.bouteilles.reverse();
            }
        },
        async reinitialisationBouteilles() {
            await this.fetchBouteillesCellier();
            if (this.filteredBouteilles.length > 0) {
                this.filteredBouteilles = [];
            }
            // Mettre à jour les valeurs du filtre
            this.setCellierFiltreValeurs({});
        },
        showSuccessPopup() {
            this.estPopupOuvert = true;
            setTimeout(() => {
                this.bouteilleSuprimeeMessage = "";
                this.$router.replace({
                    query: { ...this.$route.query, message: "" },
                });
                this.estPopupOuvert = false;
            }, 2000);
        },
        fermerPopup() {
            this.estPopupOuvert = false;
        },

        ...mapMutations(["setCellierFiltreValeurs", "setCellierActif"]),
    },
};
</script>
