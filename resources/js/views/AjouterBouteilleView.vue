<template>
    <section class="mt-12">
        <div class="bg-bg-rose m-4 p-3 shadow-md rounded">
            <form @submit.prevent="ajouterBouteille">
                <h3 class="mb-4 text-vin-rouge font-bold text-xl">
                    Ajouter une bouteille
                </h3>
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
                    />
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
                    ></textarea>
                </div>

                <div class="mb-4">
                    <label
                        for="photo"
                        class="block text-lg text-left font-bold text-vin-rouge"
                        >Photo</label
                    >
                    <input
                        type="file"
                        id="photo"
                        ref="photoInput"
                        @change="chargerPhoto"
                        class="w-full rounded pt-2 pb-2 pl-1 pr-1"
                    />
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
                    />
                </div>

                <div class="mb-4">
                    <label
                        for="annee"
                        class="block text-lg text-left font-bold text-vin-rouge"
                        >Note (%)</label
                    >
                    <input
                        v-model="notes"
                        id="annee"
                        class="w-full rounded pt-2 pb-2 pl-1 pr-1"
                    />
                </div>
                <div class="mb-4">
                    <label
                        for="annee"
                        class="block text-lg text-left font-bold text-vin-rouge"
                        >prix (Optionel)</label
                    >
                    <input
                        v-model="prix"
                        id="annee"
                        class="w-full rounded pt-2 pb-2 pl-1 pr-1"
                    />
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
import { required, minLength, integer, helpers } from "@vuelidate/validators";

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
            code_saq: null,
            prix: 0,
            notes: "",
            nbr_notes: null,
            pays_id: null,
            categorie_id: null,
            url_saq: null,
            annee: null,
            message: "",
            pays: [],
            categories: [],
        };
    },

    validatins() {
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
                numeric: helpers.regex("numeric", /^[0-9]+(\.[0-9]{1,2})?$/),
            },
            photo: {
                fileSize: fileSize(2048 * 1024),
            },
        };
    },
    methods: {
        ajouterBouteille: async function () {
            const formData = new FormData();
            formData.append("nom", this.nom);
            formData.append("description", this.description);
            if (this.photo) {
                formData.append("photo", this.photo, this.photo.name);
            }
            formData.append("code_saq", this.code_saq);
            formData.append("prix", this.prix);
            formData.append("notes", this.notes);
            formData.append("nbr_notes", this.nbr_notes);
            formData.append("pays_id", this.pays_id);
            formData.append("categorie_id", this.categorie_id);
            formData.append("url_saq", this.url_saq);
            formData.append("annee", this.annee);

            console.log(Array.from(formData.entries()));
            try {
                const reponse = await BouteilleDataService.create(formData);
                console.log(reponse);
                // this.message = reponse.data.message;
            } catch (error) {
                console.error(error);
            } finally {
                // this.$emit("loading:end");
            }
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
                console.log(this.categories);
            } catch (error) {
                console.error(error);
            } finally {
            }
        },
        chargerPhoto(event) {
            if (event.target.files.length > 0) {
                this.photo = event.target.files[0];
            } else {
                this.photo = null;
            }
            console.log("Photo:", this.photo);
        },
    },
    mounted: async function () {
        await this.getCategories();
        await this.getPays();
    },
};
</script>
