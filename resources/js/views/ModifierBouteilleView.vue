<template>
    <section v-if="afficherTemplate" class="m-4 mt-6">
        <div class="mb-6 flex justify-start">
            <button
                @click="$router.go(-1)"
                class="bg-vin_blanc hover:bg-gray-700 focus:bg-gray-700 text-white font-bold rounded-full cursor-pointer transform transition-all duration-200"
            >
                <i class="material-symbols-outlined py-4 px-4"> arrow_back </i>
            </button>
        </div>
        <div class="bg-bg-rose p-3 shadow-md rounded-lg">
            <form
                @submit.prevent="modifierBouteille"
                enctype="multipart/form-data"
            >
                <h3 class="mb-4 text-vin-rouge font-bold text-lg">
                    Modifier votre bouteille
                </h3>
                <!-- Erreurs serveur -->
                <p v-if="erreurServeur" class="block text-md text-red-500">
                    {{ erreurServeur }}
                </p>
                <p v-if="message" class="block text-md text-green-500">
                    {{ message }}
                </p>
                <!-- Nom -->
                <div class="mb-4">
                    <label
                        for="nom"
                        class="block text-md text-left font-bold text-vin-rouge"
                        >Nom</label
                    >
                    <input
                        v-model="nom"
                        id="nom"
                        class="w-full rounded pt-2 pb-2 pl-1 pr-1 h-8"
                        :class="{
                            'border border-red-500':
                                v$.nom.$error && v$.nom.$dirty,
                            'border border-green-500':
                                !v$.nom.$error && v$.nom.$dirty,
                        }"
                    />
                    <p v-if="v$.nom.$error" class="block text-xs text-red-500">
                        Veillez entrer un nom valide
                    </p>
                </div>
                <!-- Pays  - Catégories -->
                <div class="flex gap-2 items-center">
                    <!-- Pays -->
                    <div class="mb-4 flex-1">
                        <label
                            for="pays_id"
                            class="block text-md text-left font-bold text-vin-rouge"
                        >
                            Pays
                        </label>
                        <select
                            v-model="pays_id"
                            id="pays_id"
                            class="w-full rounded pt-2 pb-2 pl-1 pr-1 bg-white"
                            :class="{
                                'border border-red-500':
                                    v$.pays_id.$error && v$.pays_id.$dirty,
                                'border border-green-500':
                                    !v$.pays_id.$error && v$.pays_id.$dirty,
                            }"
                        >
                            <option disabled value="">
                                Sélectionnez un pays
                            </option>
                            <option
                                v-for="paysItem in pays"
                                :key="paysItem.id"
                                :value="paysItem.id"
                            >
                                {{ paysItem.nom }}
                            </option>
                        </select>
                        <p
                            v-if="v$.pays_id.$error"
                            class="block text-md text-red-500"
                        >
                            Veillez sélectionner un pays
                        </p>
                    </div>
                    <!-- Catégorie -->
                    <div class="mb-4 flex-1">
                        <label
                            for="categorie_id"
                            class="block text-md text-left font-bold text-vin-rouge"
                        >
                            Catégorie
                        </label>
                        <select
                            v-model="categorie_id"
                            id="categorie_id"
                            class="w-full rounded pt-2 pb-2 pl-1 pr-1 bg-white"
                            :class="{
                                'border border-red-500':
                                    v$.categorie_id.$error &&
                                    v$.categorie_id.$dirty,
                                'border border-green-500':
                                    !v$.categorie_id.$error &&
                                    v$.categorie_id.$dirty,
                            }"
                        >
                            <option disabled value="">
                                Sélectionnez une catégorie
                            </option>
                            <option
                                v-for="categorie in categories"
                                :key="categorie.id"
                                :value="categorie.id"
                            >
                                {{ categorie.nom }}
                            </option>
                        </select>
                        <p
                            v-if="v$.categorie_id.$error"
                            class="block text-md text-red-500"
                        >
                            Veillez sélectionner une catégorie
                        </p>
                    </div>
                </div>
                <!-- Ajouter une photo -->
                <div class="mb-4">
                    <label
                        for="photo"
                        class="block text-md text-left font-bold text-vin-rouge"
                        >Select an image:</label
                    >
                    <input
                        @change="chargerPhoto"
                        id="photo"
                        type="file"
                        accept="image/*"
                        name="photo"
                        class="w-full rounded pt-2 pb-2 pl-1 pr-1 bg-white"
                    />
                </div>
                <!-- Prix et Année -->
                <div class="flex gap-2 items-center">
                    <!-- Quantité  -->
                    <div class="mb-4 flex-1">
                        <label
                            for="quantite"
                            class="block text-md text-left font-bold text-vin-rouge"
                            >Quantité</label
                        >
                        <input
                            type="number"
                            v-model="quantite"
                            id="quantite"
                            class="w-full rounded py-2 px-1 h-8"
                            :class="{
                                'border border-red-500':
                                    v$.quantite.$error && v$.quantite.$dirty,
                                'border border-green-500':
                                    !v$.quantite.$error && v$.quantite.$dirty,
                            }"
                        />
                        <p
                            v-if="v$.quantite.$error"
                            class="block text-xs text-red-500"
                        >
                            Veuillez entrer une quantité valide
                        </p>
                    </div>
                    <!-- Prix -->
                    <div class="mb-4 flex-1">
                        <label
                            for="annee"
                            class="block text-md text-left font-bold text-vin-rouge"
                            >prix</label
                        >
                        <input
                            v-model="prix"
                            id="annee"
                            class="w-full rounded pt-2 pb-2 pl-1 pr-1 h-8 bg-white"
                            :class="{
                                'border border-red-500':
                                    v$.prix.$error && v$.prix.$dirty,
                                'border border-green-500':
                                    !v$.prix.$error && v$.prix.$dirty,
                            }"
                        />
                        <p
                            v-if="v$.prix.$error"
                            class="block text-xs text-red-500"
                        >
                            Veillez entrer un prix valide
                        </p>
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        class="mb-4 mt-4 bg-vin-rouge text-white rounded py-2 px-6"
                    >
                        modifier
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
    numeric,
    minValue,
    maxValue,
} from "@vuelidate/validators";

import PaysDataService from "@/services/PaysDataService";
import CategorieDataService from "@/services/CategorieDataService";
import BouteilleDataService from "@/services/BouteilleDataService";
import CellierDataService from "../services/CellierDataService";

export default {
    props: {
        bouteilleId: {
            type: String,
            required: true,
        },
        cellierId: {
            type: String,
            required: true,
        },
    },
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
            pays: [],
            categories: [],
            message: "",
            quantite: 1,
            pivot: null,
            afficherTemplate: false,
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
        modifierBouteille: async function () {
            this.v$.$touch(); // Déclenche la validation

            if (this.v$.$invalid) {
                // Si le formulaire est invalide, arrêtez le processus de soumission
                this.erreurServeur = "";
                this.message = "";
                return;
            }

            const formData = new FormData();

            formData.append("nom", this.nom);
            formData.append("description", this.description);
            if (this.photo) {
                formData.append("photo", this.photo);
            }

            formData.append("prix", this.prix);
            formData.append("note", this.note);
            formData.append("nbr_notes", this.nbr_notes);
            formData.append("pays_id", this.pays_id);
            formData.append("categorie_id", this.categorie_id);
            formData.append("_method", "PUT");

            formData.append("annee", this.annee);
            formData.append("quantite", this.quantite);

            // Met à jour les données de la bouteille et retourne un message de succès
            try {
                const reponse = await BouteilleDataService.update(
                    this.bouteilleId,
                    this.cellierId,
                    formData
                );
                // renvoyer a la page celliers avec un message de succès
                this.$router.push({
                    name: "mes-celliers",
                    params: {
                        message: reponse.data.message,
                    },
                });
            } catch (error) {
                console.error(error);
                this.erreurServeur = error.response.data.message;
            } finally {
            }
        },
        // Récupère les données de la bouteille à modifier
        obtenirBouteille: async function () {
            try {
                const response = await BouteilleDataService.get(
                    this.bouteilleId
                );
                const bouteille = response.data.bouteille;

                // Peuple le formulaire avec les données extraites
                this.nom = bouteille.nom;
                this.description !== "null" ? bouteille.description : null;
                this.prix = bouteille.prix;
                this.note = bouteille.note;
                this.nbr_notes = bouteille.nbr_notes;
                this.pays_id = bouteille.pays_id;
                this.categorie_id = bouteille.categorie_id;
                this.annee =
                    bouteille.annee && bouteille.annee !== "null"
                        ? bouteille.annee
                        : null;
            } catch (error) {
                console.error(error);
            }
        },
        // Récupère les pays
        getPays: async function () {
            try {
                const reponse = await PaysDataService.getAll();
                this.pays = reponse.data;
            } catch (error) {
                console.error(error);
            } finally {
            }
        },
        // Récupère la quantité de la bouteille dans le cellier
        getCellierBouteillePivot: async function () {
            try {
                const reponse =
                    await CellierDataService.getCellierBouteillePivot(
                        this.cellierId,
                        this.bouteilleId
                    );
                this.quantite = reponse.data.pivot.quantite;
            } catch (error) {
                console.error(error);
            } finally {
                this.$nextTick(() => {
                    this.$emit("loading:end");
                    this.afficherTemplate = true;
                });
            }
        },
        // Récupère les catégories
        getCategories: async function () {
            try {
                const reponse = await CategorieDataService.getAll();
                this.categories = reponse.data.categories;
            } catch (error) {
                console.error(error);
            } finally {
            }
        },
        // Récupère la photo de la bouteille
        chargerPhoto(e) {
            this.photo = e.target.files[0];
        },
    },
    mounted: async function () {
        this.$emit("loading:start");
        await this.obtenirBouteille();
        await this.getCategories();
        await this.getPays();
        await this.getCellierBouteillePivot();
    },
};
</script>
