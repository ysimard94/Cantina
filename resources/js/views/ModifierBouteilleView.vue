<template>
    <section class="m-4 mt-6">
        <div class="mb-4 flex justify-start">
            <button
                @click="$router.go(-1)"
                class="bg-vin_blanc hover:bg-gray-700 text-white font-bold rounded-full cursor-pointer"
            >
                <i class="material-symbols-outlined py-4 px-4"> arrow_back </i>
            </button>
        </div>
        <div class="bg-bg-rose m-4 p-3 shadow-md rounded">
            <form
                @submit.prevent="modifierBouteille"
                enctype="multipart/form-data"
            >
                <h3 class="mb-4 text-vin-rouge font-bold text-xl">
                    Modifier votre bouteille
                </h3>
                <!-- Erreurs serveur -->
                <p v-if="erreurServeur" class="block text-md text-red-500">
                    {{ erreurServeur }}
                </p>
                <p v-if="message" class="block text-md text-green-500">
                    {{ message }}
                </p>
                <div class="mb-4">
                    <label
                        for="nom"
                        class="block text-lg text-left font-bold text-vin-rouge"
                        >Nom</label
                    >
                    <input
                        v-model="nom"
                        id="nom"
                        class="w-full rounded pt-2 pb-2 pl-1 pr-1"
                        :class="{
                            'border border-red-500':
                                v$.nom.$error && v$.nom.$dirty,
                            'border border-green-500':
                                !v$.nom.$error && v$.nom.$dirty,
                        }"
                    />
                    <p v-if="v$.nom.$error" class="block text-md text-red-500">
                        Veillez entrer un nom valide
                    </p>
                </div>
                <!-- Pays  - Catégories -->
                <div class="flex gap-2 items-center">
                    <!-- Pays -->
                    <div class="mb-4 flex-1">
                        <label
                            for="pays_id"
                            class="block text-lg text-left font-bold text-vin-rouge"
                        >
                            Pays
                        </label>
                        <select
                            v-model="pays_id"
                            id="pays_id"
                            class="w-full rounded pt-2 pb-2 pl-1 pr-1"
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
                            class="block text-lg text-left font-bold text-vin-rouge"
                        >
                            Catégorie
                        </label>
                        <select
                            v-model="categorie_id"
                            id="categorie_id"
                            class="w-full rounded pt-2 pb-2 pl-1 pr-1"
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
                <!-- Année -->
                <div class="mb-4">
                    <label
                        for="annee"
                        class="block text-lg text-left font-bold text-vin-rouge"
                        >Année</label
                    >
                    <input
                        v-model="annee"
                        id="annee"
                        class="w-full rounded pt-2 pb-2 pl-1 pr-1"
                        :class="{
                            'border border-red-500':
                                v$.annee.$error && v$.annee.$dirty,
                            'border border-green-500':
                                !v$.annee.$error && v$.annee.$dirty,
                        }"
                    />
                    <p
                        v-if="v$.annee.$error"
                        class="block text-md text-red-500"
                    >
                        Veillez entrer une année valide
                    </p>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label
                        for="description"
                        class="block text-lg text-left font-bold text-vin-rouge"
                        >Description</label
                    >
                    <textarea
                        v-model="description"
                        id="description"
                        class="w-full rounded pt-2 pb-2 pl-1 pr-1"
                    ></textarea>
                </div>

                <!-- add a phot here -->
                <div class="mb-4">
                    <label
                        for="photo"
                        class="block text-lg text-left font-bold text-vin-rouge"
                        >Select an image:</label
                    >
                    <input
                        @change="chargerPhoto"
                        id="photo"
                        type="file"
                        accept="image/*"
                        name="photo"
                        class="w-full rounded pt-2 pb-2 pl-1 pr-1"
                    />
                </div>
                <div class="flex gap-2 items-center">
                    <!-- Note -->
                    <div class="mb-4 flex-1">
                        <label
                            for="annee"
                            class="block text-lg text-left font-bold text-vin-rouge"
                            >Note (%)</label
                        >
                        <input
                            v-model="note"
                            id="annee"
                            class="w-full rounded pt-2 pb-2 pl-1 pr-1"
                            :class="{
                                'border border-red-500':
                                    v$.note.$error && v$.note.$dirty,
                                'border border-green-500':
                                    !v$.note.$error && v$.note.$dirty,
                            }"
                        />
                        <p
                            v-if="v$.note.$error"
                            class="block text-md text-red-500"
                        >
                            Veillez entrer une note valide
                        </p>
                    </div>
                    <!-- Prix -->
                    <div class="mb-4 flex-1">
                        <label
                            for="annee"
                            class="block text-lg text-left font-bold text-vin-rouge"
                            >prix</label
                        >
                        <input
                            v-model="prix"
                            id="annee"
                            class="w-full rounded pt-2 pb-2 pl-1 pr-1"
                            :class="{
                                'border border-red-500':
                                    v$.prix.$error && v$.prix.$dirty,
                                'border border-green-500':
                                    !v$.prix.$error && v$.prix.$dirty,
                            }"
                        />
                        <p
                            v-if="v$.prix.$error"
                            class="block text-md text-red-500"
                        >
                            Veillez entrer un prix valide
                        </p>
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        class="mb-4 mt-4 bg-vin-rouge text-vin-blanc rounded pt-1 pb-1 pr-5 pl-5"
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
    helpers,
    numeric,
} from "@vuelidate/validators";
import axios from "axios";

import PaysDataService from "@/services/PaysDataService";
import CategorieDataService from "@/services/CategorieDataService";
import BouteilleDataService from "@/services/BouteilleDataService";

export default {
    props: {
        id: {
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
            note: "",
            nbr_notes: 0,
            pays_id: null,
            categorie_id: null,
            annee: null,
            message: "",
            pays: [],
            categories: [],
            message: "",
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
                console.log(this.photo);
                formData.append("photo", this.photo);
            }

            formData.append("prix", this.prix);
            formData.append("note", this.note);
            formData.append("nbr_notes", this.nbr_notes);
            formData.append("pays_id", this.pays_id);
            formData.append("categorie_id", this.categorie_id);

            formData.append("annee", this.annee);

            // Met à jour les données de la bouteille et retourne un message de succès
            try {
                const reponse = await BouteilleDataService.update(
                    this.id,
                    formData
                );
                // renvoyer a la page celliers avec un message de succès

                this.$router.push({
                    name: "mes-celliers",
                    query: { message: reponse.data.message },
                });
            } catch (error) {
                console.error(error);
            } finally {
            }
        },
        obtenirBouteille: async function (bouteilleId) {
            try {
                const response = await BouteilleDataService.get(bouteilleId);
                const bouteille = response.data.bouteille;

                // Populate the form with the fetched data
                this.nom = bouteille.nom;
                this.description = bouteille.description;
                this.prix = bouteille.prix;
                this.note = bouteille.note;
                this.nbr_notes = bouteille.nbr_notes;
                this.pays_id = bouteille.pays_id;
                this.categorie_id = bouteille.categorie_id;
                this.annee =
                    bouteille.annee && bouteille.annee !== "null"
                        ? bouteille.annee
                        : null;
                // ...and so on for other fields
            } catch (error) {
                console.error(error);
            }
        },
        getPays: async function () {
            try {
                const reponse = await PaysDataService.getAll();
                this.pays = reponse.data;
                console.log(this.pays);
            } catch (error) {
                console.error(error);
            } finally {
            }
        },
        getCategories: async function () {
            try {
                const reponse = await CategorieDataService.getAll();
                this.categories = reponse.data.categories;
                console.log(this.categories);
            } catch (error) {
                console.error(error);
            } finally {
            }
        },
        chargerPhoto(e) {
            this.photo = e.target.files[0];
            console.log(this.photo);
        },
    },
    mounted: async function () {
        await this.obtenirBouteille(this.id);
        await this.getCategories();
        await this.getPays();
    },
};
</script>
