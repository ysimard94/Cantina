<template>
    <section class="mt-12">
        <div class="bg-bg-rose m-4 p-3 shadow-md rounded">
            <form
                @submit.prevent="ajouterBouteille"
                enctype="multipart/form-data"
            >
                <h3 class="mb-4 text-vin-rouge font-bold text-xl">
                    Ajouter une bouteille
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
                        :class="{
                            'border border-red-500':
                                v$.description.$error && v$.description.$dirty,
                            'border border-green-500':
                                !v$.description.$error && v$.description.$dirty,
                        }"
                    ></textarea>
                    <p
                        v-if="v$.description.$error"
                        class="block text-md text-red-500"
                    >
                        Veillez entrer une description
                    </p>
                </div>
                <div class="mb-4">
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
                        <option disabled value="">Sélectionnez un pays</option>
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
                <div class="mb-4">
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

                <div class="mb-4">
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
                    <p v-if="v$.note.$error" class="block text-md text-red-500">
                        Veillez entrer une note valide
                    </p>
                </div>
                <div class="mb-4">
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
                    <p v-if="v$.prix.$error" class="block text-md text-red-500">
                        Veillez entrer un prix valide
                    </p>
                </div>

                <div>
                    <button
                        type="submit"
                        class="mb-4 mt-4 bg-vin-rouge text-vin-blanc rounded pt-1 pb-1 pr-5 pl-5"
                    >
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
} from "@vuelidate/validators";

import PaysDataService from "@/services/PaysDataService";
import CategorieDataService from "@/services/CategorieDataService";
import BouteilleDataService from "@/services/BouteilleDataService";

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
            description: {
                minLength: minLength(2),
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

            try {
                this.$emit("loading:start");

                // Appeler le service pour créer la bouteille
                const reponse = await BouteilleDataService.create(formData);

                // Afficher un message de succès
                this.message = reponse.data.message;
            } catch (erreur) {
                // Afficher un message d'erreur
                this.erreurServeur = erreur.response.data.erreur;
            } finally {
                // Émettre un événement pour indiquer la fin du chargement
                this.$emit("loading:end");
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
    },
    mounted: async function () {
        await this.getCategories();
        await this.getPays();
    },
};
</script>
