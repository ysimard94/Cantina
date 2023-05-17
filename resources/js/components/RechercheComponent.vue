<template>
    <div :class="{
        'transform translate-y-5 opacity-0 -z-10': !rechercheOuverte,
        'transform translate-y-0 opacity-100': rechercheOuverte,
    }" class="flex w-full fixed bottom-[56px] mb-5 transition-all duration-300">
        <div class="flex flex-col mx-auto text-left bg-bg-rose w-full max-w-xl rounded shadow-md p-3 gap-2 font-sans">
            <form @submit.prevent="" class="flex-grow">
                <div class="relative">
                    <!-- Affiche ou non avec une animation si la recherche est vide ou non -->
                    <ul class="absolute mt-3 bg-white w-full rounded shadow z-10 transform transition-all duration-300 bottom-10"
                        :class="{
                            'transform translate-y-1 opacity-0': rechercheVide,
                            'transform translate-y-0 opacity-100': !rechercheVide,
                        }"
                        style="max-height: 10rem; overflow-y: scroll;">
                        <!-- Liste des bouteilles suggérées, et afficher une bordure en bas sauf pour la dernière suggestion -->
                        <li class="mx-4 flex text-left"
                            :class="{ 'border-b-2': index !== bouteilles.length - 1 }"
                            v-for="(bouteille, index) in bouteilles"
                            :key="index">
                            <router-link :to="{
                                name: 'resultat-recherche',
                                params: { valeur: bouteille.nom },
                            }"
                            @click="reinitialiserRecherche(); reinitialiserPage();"
                            class="pt-1">
                                {{ bouteille.nom }}
                            </router-link>
                        </li>
                    </ul>
                    <label class="relative flex items-center">
                        <input v-model="valeurRecherche" type="text" class="w-full py-1 pl-2 pr-[32px] rounded"
                            placeholder="Ajouter une bouteille de la SAQ" @keyup="recherche" @keyup.enter="goAuxResultats(valeurRecherche)"/>
                        <button class="material-symbols-outlined absolute right-0 p-1" @click="goAuxResultats(valeurRecherche)">
                            search
                        </button>
                    </label>
                </div>
            </form>
            <span>
                <!-- Lien qui redirige vers le formulaire pour ajouter sa propre bouteille -->
                <router-link :to="{ name: 'ajouter-bouteille' }"
                    @click="reinitialiserRecherche(); reinitialiserPage();"
                    class="text-vin-rouge border-b border-vin-rouge hover:text-red-700 ml-2">
                    Ajouter votre propre bouteille?
                </router-link>
            </span>
        </div>
    </div>
</template>

<script>
import SaqProduitsDataService from "../services/SaqProduitsDataService";
export default {
    name: "RechercheComponent",
    props: {
        rechercheOuverte: Boolean,
    },
    data() {
        return {
            valeurRecherche: "",
            tempsRecherche: null,
            rechercheVide: true,
            bouteilles: [],
        };
    },
    methods: {
        // Recherche les bouteilles de la SAQ selon la valeur de recherchée, avec un délai de 500ms à chaque frappe de touche pour éviter de faire trop de requêtes
        async recherche() {
            clearTimeout(this.tempsRecherche);

            this.tempsRecherche = setTimeout(async () => {
                if (this.valeurRecherche.length >= 3) {
                    this.rechercheVide = false;
                    try {
                        const reponse = await SaqProduitsDataService.getBouteilles(this.valeurRecherche);
                        this.bouteilles = reponse.data;
                    } catch (e) {
                        console.log(e);
                    }
                }
            }, 500);
            // Va vider les suggestions si le champ de recherche est sous 3 caractères
            if (this.valeurRecherche.length < 3) {
                this.rechercheVide = true;
                this.tempsRecherche = setTimeout(() => {
                    this.bouteilles = [];
                }, 500);
            }
        },
        // Réinitialise la recherche
        reinitialiserRecherche() {
            this.rechercheVide = true;
            this.valeurRecherche = "";
            this.tempsRecherche = setTimeout(() => {
                this.bouteilles = [];
            }, 500);
        },
        // Réinitialise la page active
        reinitialiserPage() {
            this.$emit("reinitialiser-page");
        },
        // Redirige vers la page de résultats de recherche
        goAuxResultats(valeurRecherche) {
            this.$router.push({
                name: 'resultat-recherche',
                params: { valeur: valeurRecherche }
            });

            this.reinitialiserRecherche();
            this.reinitialiserPage();
        },
    },
    watch: {
        // Si le champ de recherche est vide, réinitialise la recherche
        rechercheOuverte(valeur) {
            if (!valeur) {
                this.reinitialiserRecherche();
            }
        },
    }
};
</script>
