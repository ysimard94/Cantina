<template>
    <div class="container mx-auto">
        <transition
            enter-active-class="transition-all duration-200 ease-out"
            enter-class="transform translate-y-full opacity-0"
            enter-to-class="transform translate-y-0  opacity-100"
            leave-active-class="transition-all duration-300 ease-in"
            leave-class="transform translate-y-0  opacity-100"
            leave-to-class="transform translate-y-full  opacity-0"
        >
            <!-- Success Message -->
            <div
                v-show="estSuccessPopup"
                class="fixed bottom-0 left-0 right-0 flex justify-center mb-20"
            >
                <div
                    class="bg-green-500 text-white font-bold rounded-lg px-4 py-2 flex items-center h-24 max-w-md shadow-lg w-full mx-2"
                >
                    <!-- Success Icon (Google Material Icons) -->
                    <span class="material-icons text-lg mr-2"
                        >check_circle</span
                    >
                    <span class="flex-1 text-center text-sm">{{
                        message
                    }}</span>
                    <button
                        @click="fermerPopup"
                        class="ml-2 material-symbols-outlined"
                    >
                        <!-- Close Icon (Google Material Icons) -->
                        <span> close </span>
                    </button>
                </div>
            </div>
        </transition>
        <!-- Boucle à travers le tableau de bouteilles de la recherche -->
        <div v-for="bouteille in bouteilles" :key="bouteille.id">
            <div
                class="bg-bg_rose overflow-hidden shadow rounded-lg px-2 py-2 m-4"
            >
                <img
                    :src="bouteille.photo"
                    alt="Bottle image"
                    class="w-16 h-32 object-cover mx-auto"
                />
                <div class="px-4 py-4">
                    <router-link
                        :to="{
                            name: 'bouteille-details',
                            params: { id: bouteille.id },
                        }"
                    >
                        <h4
                            class="text-lg font-semibold text-vin_rouge text-left font-serif underline"
                        >
                            {{ bouteille.nom }}
                        </h4></router-link
                    >
                    <div class="text-left font-serif font-bold mt-2 text-lg">
                        $ {{ bouteille.prix }}
                    </div>
                    <div class="mt-2 flex justify-between items-center">
                        <div class="font-sans">
                            <div class="text-black font-medium text-left">
                                {{ bouteille.pays.nom }}
                            </div>
                            <div class="text-black font-medium text-left">
                                {{ bouteille.categorie.nom }}
                            </div>
                        </div>
                        <div class="flex mb-auto">
                            <template v-for="i in 5" :key="i">
                                <svg
                                    :class="{
                                        'text-vin-blanc':
                                            bouteille.note / 20 >= i,
                                    }"
                                    class="w-4 h-4 fill-current"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M12 2 L15.09 8.09 L23 9.54 L17.91 15.5 L19.64 23.54 L12 20.59 L4.36 23.54 L6.09 15.5 L1 9.54 L8.91 8.09 L12 2 Z"
                                    />
                                </svg>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="flex items-center mx-3 mb-3 hover:text-geen-600">
                    <!-- Champ select de tous les celliers de l'utilisateur -->
                    <select
                        id="cellier"
                        class="p-2 font-sans w-full rounded-md shadow-sm bg-slate-100 border-gray-300 border-2 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        :class="{ hidden: this.celliers.length === 1 }"
                    >
                        <option disabled>-- Sélectionner un cellier --</option>
                        <option
                            v-for="cellier in celliers"
                            :value="cellier.id"
                            :key="cellier.id"
                        >
                            {{ cellier.nom }}
                        </option>
                    </select>
                    <input
                        type="number"
                        :value="1"
                        id="quantite"
                        class="p-2 font-sans rounded-md shadow-sm bg-slate-100 border-gray-300 border-2 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-[40px] w-16 ml-1 mr-auto"
                        placeholder="Quantité"
                        min="1"
                    />
                    <!-- Bouton pour ajouter la bouteille au cellier -->
                    <button
                        class="material-symbols-outlined text-4xl ml-2 add-button transform transition-all hover:text-green-600 focus:text-green-600 hover:scale-125 active:scale-90"
                        @click="ajouterBouteille(bouteille.id, $event)"
                    >
                        add
                    </button>
                    <button
                        class="material-symbols-outlined text-4xl ml-2 add-button transform transition-all hover:text-green-600 focus:text-green-600 hover:scale-125 active:scale-90"
                        @click="ajouterBouteilleALaListe(bouteille.id)"
                    >
                        post_add
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import BouteilleDataService from "@/services/BouteilleDataService.js";
import CellierDataService from "@/services/CellierDataService.js";

export default {
    name: "ResultatView",
    data() {
        return {
            bouteilles: [],
            celliers: [],
            message: "",
            estSuccessPopup: false,
            bouteille: {
                quantite: 1,
            },
        };
    },
    methods: {
        // Méthode pour récupérer les bouteilles avec la valeur de la recherche
        async obtenirBouteille() {
            try {
                const reponse =
                    await BouteilleDataService.getResultatsBouteilles(
                        this.$route.params.valeur
                    );
                this.bouteilles = reponse.data;
            } catch (e) {
                console.log(e);
            }
        },

        // Méthode pour récupérer les celliers de l'utilisateur
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

        handleChangerCellier() {
            console.log(this.cellierActif);
        },

        // Méthode pour ajouter la bouteille au cellier sélectionné ainsi que la quantité
        async ajouterBouteille(bouteilleId, event) {
            let cellierId =
                event.target.parentNode.querySelector("#cellier").value;
            let quantite =
                event.target.parentNode.querySelector("#quantite").value;
            try {
                const reponse =
                    await BouteilleDataService.ajouterBouteilleAuCellier(
                        cellierId,
                        bouteilleId,
                        quantite
                    );

                this.message = reponse.data.message;
                this.estSuccessPopup = true;
                // Pour fermer le popup après 5 secondes
                setTimeout(() => {
                    this.message = "";
                    this.estSuccessPopup = false;
                }, 2000);
            } catch (error) {
                console.log(reponse.data);
            }
        },
        async ajouterBouteilleALaListe(bouteilleId) {
            try {
                const reponse =
                    await BouteilleDataService.ajouterBouteilleALaListe(
                        this.$store.state.session.utilisateur_id,
                        bouteilleId
                    );
                this.message = reponse.data.message;
                this.estSuccessPopup = true;
                // Pour fermer le popup après 5 secondes
                setTimeout(() => {
                    this.message = "";
                    this.estSuccessPopup = false;
                }, 2000);
            } catch (error) {
                console.log(reponse.data);
            }
        },
        // Pour fermer le popup au clic du bouton X
        fermerPopup() {
            this.message = "";
            this.estSuccessPopup = false;
        },
    },
    async mounted() {
        await this.fetchCelliers();
        this.obtenirBouteille();
    },
    // Va vérifier si la route a changé et refaire la requête si c'est le cas
    watch: {
        $route() {
            this.obtenirBouteille();
        },
    },
};
</script>
