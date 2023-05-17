<template>
    <section class="m-4 mt-6">
        <div class="mb-6 flex justify-start">
            <button @click="$router.go(-1)"
                class="bg-vin_blanc hover:bg-gray-700 focus:bg-gray-700 text-white font-bold rounded-full cursor-pointer transform transition-all durtation-200">
                <i class="material-symbols-outlined py-4 px-4"> arrow_back </i>
            </button>
        </div>

        <div class="bg-bg-rose p-3 shadow-md rounded-lg">
            <form @submit.prevent="ajouterBouteille" enctype="multipart/form-data">
                <!-- Titre -->
                <h3 class="mb-4 text-vin-rouge font-bold text-lg">
                    Ajouter une bouteille
                </h3>
                <!-- Erreurs serveur -->
                <p v-if="erreurServeur" class="block text-sm text-red-500">
                    {{ erreurServeur }}
                </p>
                <!-- Erreurs de validation client -->
                <p v-if="message" class="block text-sm text-green-500">
                    {{ message }}
                </p>
                <!-- Nom -->
                <div class="mb-4">
                    <label for="nom" class="block text-md text-left font-bold text-vin-rouge">Nom</label>
                    <input v-model="nom" id="nom" class="w-full h-8 py-1 pl-2 rounded" :class="{
                        'border border-red-500':
                            v$.nom.$error && v$.nom.$dirty,
                        'border border-green-500':
                            !v$.nom.$error && v$.nom.$dirty,
                    }" />
                    <p v-if="v$.nom.$error" class="block text-xs text-red-500">
                        Veillez entrer un nom valide
                    </p>
                </div>
                <!-- Pays  - Catégories -->
                <div class="flex gap-2 items-center">
                    <!-- Pays -->
                    <div class="mb-4 flex-1">
                        <label for="pays_id" class="block text-md text-left font-bold text-vin-rouge">
                            Pays
                        </label>
                        <select v-model="pays_id" id="pays_id" class="w-full py-1 pl-2 h-8 rounded bg-white" :class="{
                            'border border-red-500':
                                v$.pays_id.$error && v$.pays_id.$dirty,
                            'border border-green-500':
                                !v$.pays_id.$error && v$.pays_id.$dirty,
                        }">
                            <option disabled value="">
                                Sélectionnez un pays
                            </option>
                            <option v-for="paysItem in pays" :key="paysItem.id" :value="paysItem.id">
                                {{ paysItem.nom }}
                            </option>
                        </select>
                        <p v-if="v$.pays_id.$error" class="block text-xs text-red-500">
                            Veillez sélectionner un pays
                        </p>
                    </div>
                    <!-- Catégories -->
                    <div class="mb-4 flex-1">
                        <label for="categorie_id" class="block text-md text-left font-bold text-vin-rouge">
                            Catégorie
                        </label>
                        <select v-model="categorie_id" id="categorie_id" class="w-full rounded py-2 px-1 h-8 bg-white"
                            :class="{
                                'border border-red-500':
                                    v$.categorie_id.$error &&
                                    v$.categorie_id.$dirty,
                                'border border-green-500':
                                    !v$.categorie_id.$error &&
                                    v$.categorie_id.$dirty,
                            }">
                            <option disabled value="">
                                Sélectionnez une catégorie
                            </option>
                            <option v-for="categorie in categories" :key="categorie.id" :value="categorie.id">
                                {{ categorie.nom }}
                            </option>
                        </select>
                        <p v-if="v$.categorie_id.$error" class="block text-xs text-red-500">
                            Veillez sélectionner une catégorie
                        </p>
                    </div>
                </div>
                <!-- Année  - Quantité -->
                <div class="flex gap-2 items-center">
                    <!-- Celliers -->
                    <div class="mb-4 flex-1">
                        <label for="cellier" class="block text-md text-left font-bold text-vin-rouge">Cellier</label>
                        <select v-model="cellier" name="cellier" class="w-full rounded px-1 h-8 bg-white">
                            <option v-for="cellier in celliers" :key="cellier.id" :value="cellier.id">
                                {{ cellier.nom }}
                            </option>
                        </select>
                    </div>
                    <!-- Quantité  -->
                    <div class="mb-4 flex-1">
                        <label for="quantite" class="block text-md text-left font-bold text-vin-rouge">Quantité</label>
                        <input type="number" v-model="quantite" id="quantite" class="w-full rounded py-2 px-1 h-8" :class="{
                            'border border-red-500':
                                v$.quantite.$error && v$.quantite.$dirty,
                            'border border-green-500':
                                !v$.quantite.$error && v$.quantite.$dirty,
                        }" />
                        <p v-if="v$.quantite.$error" class="block text-xs text-red-500">
                            Veuillez entrer une quantité valide
                        </p>
                    </div>
                </div>
                <!-- Image -->
                <div class="mb-4">
                    <label for="photo" class="block text-md text-left font-bold text-vin-rouge">Select an image:</label>
                    <input @change="chargerPhoto" id="photo" type="file" accept="image/*" name="photo"
                        class="w-full text-md rounded pt-2 pb-2 pl-1 pr-1 bg-white" />
                </div>
                <!-- Année - Notes - Prix -->
                <div class="flex gap-2 items-center">
                    <!-- Prix -->
                    <div class="mb-4 flex-1">
                        <label for="prix" class="block text-md text-left font-bold text-vin-rouge">Prix</label>
                        <input type="number" v-model="prix" id="prix" class="w-full rounded pt-2 pb-2 pl-1 pr-1 h-8" :class="{
                            'border border-red-500':
                                v$.prix.$error && v$.prix.$dirty,
                            'border border-green-500':
                                !v$.prix.$error && v$.prix.$dirty,
                        }" />
                        <p v-if="v$.prix.$error" class="block text-xs text-red-500">
                            Veillez entrer un prix valide
                        </p>
                    </div>
                </div>
                <!-- Validation -->
                <div>
                    <button type="submit" class="mb-4 mt-4 bg-vin-rouge text-white rounded py-2 px-6">
                        Ajouter
                    </button>
                </div>
            </form>
        </div>
    </section>
</template>

<script>
import { useVuelidate } from "@vuelidate/core";
import {
    required,
    minLength,
    integer,
    helpers,
    numeric,
    minValue,
    maxValue,
} from "@vuelidate/validators";

import PaysDataService from "@/services/PaysDataService";
import CategorieDataService from "@/services/CategorieDataService";
import BouteilleDataService from "@/services/BouteilleDataService";
import CellierDataService from "@/services/CellierDataService";

export default {
    setup() {
        return {
            v$: useVuelidate(),
        };
    },
    data() {
        return {
            nom: "",
            description: "",
            photo: null,
            prix: 0,
            note: 0,
            nbr_notes: 0,
            pays_id: null,
            categorie_id: null,
            annee: null,
            message: "",
            pays: [],
            categories: [],
            celliers: [],
            cellier: null,
            quantite: 1,
        };
    },

    validations() {
        return {
            nom: {
                required,
                minLength: minLength(2),
            },
            annee: {
                integer: integer,
                maxYear: (value) => value <= new Date().getFullYear(),
            },
            prix: {
                numeric,
            },
            note: {
                numeric,
                minValue: minValue(0),
                maxValue: maxValue(100),
            },
            quantite: {
                required,
                integer: integer,
                minValue: minValue(1),
            },
            nbr_notes: {
                integer: integer,
            },
            pays_id: {
                required,
            },
            categorie_id: {
                required,
            },
        };
    },
    methods: {
        ajouterBouteille: async function () {
            this.v$.$touch(); // Déclenche la validation

            if (this.v$.$invalid) {
                // Si le formulaire est invalide, arrêtez le processus de soumission
                this.erreurServeur = "";
                this.message = "";
                return;
            }

            // Créer un objet FormData
            const formData = new FormData();

            // Ajouter les données de la bouteille dans le FormData
            formData.append("nom", this.nom);
            if (this.photo) {
                formData.append("photo", this.photo);
            }
            formData.append("prix", this.prix);
            formData.append("pays_id", this.pays_id);
            formData.append("categorie_id", this.categorie_id);
            formData.append("quantite", this.quantite);

            try {
                this.$emit("loading:start");

                // Appeler le service pour créer la bouteille
                const reponse = await BouteilleDataService.create(
                    this.cellier,
                    formData
                );


                // renvoyer a la page celliers avec un message de succès
                this.$router.push({
                    name: "mes-celliers",
                    query: { message: reponse.data.message },
                });
            } catch (erreur) {
                // Afficher un message d'erreur
                this.erreurServeur = erreur.response.data.erreur;
            } finally {
                // Émettre un événement pour indiquer la fin du chargement
                this.$emit("loading:end");
            }
        },
        chargerPhoto(e) {
            this.photo = e.target.files[0];
        },
        getPays: async function () {
            try {
                const reponse = await PaysDataService.getAll();
                this.pays = reponse.data;
            } catch (error) {
                console.error(error);
            } finally {
            }
        },
        getCategories: async function () {
            try {
                const reponse = await CategorieDataService.getAll();
                this.categories = reponse.data.categories;
            } catch (error) {
                console.error(error);
            } finally {
            }
        },
        // Obtenir la liste des celliers
        async fetchCelliers() {
            try {
                const response = await CellierDataService.getAll();
                this.celliers = response.data;
                console.log(this.celliers)
            } catch (error) {
                console.log(error);
            }
        },
    },
    mounted: async function () {
        await this.getCategories();
        await this.getPays();
        // Obtenir la liste des celliers et mettre le premier cellier de sélectionné par défaut
        this.fetchCelliers().then(() => {
            if (this.celliers.length > 0) {
                this.cellier = this.celliers[0].id
            }
        });

    },
};
</script>
