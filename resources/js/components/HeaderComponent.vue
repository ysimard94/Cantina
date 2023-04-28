<template>
    <header class="shadow bg-vin-rouge">
        <div class="container mx-auto px-4 py-3 sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <div class="flex items-center w-full">
                    <!-- Logo -->
                    <div class="mr-4">
                        <router-link v-if="estConnecter" class="flex-shrink-0 flex items-center"
                            :to="{ name: 'mes-celliers' }">
                            <img class="max-w-[54px]" src="@assets/vino-logo.png" alt="Vino Logo" />
                        </router-link>
                        <router-link v-else class="flex-shrink-0 flex items-center" :to="{ name: 'connexion' }">
                            <img class="max-w-[54px]" src="@assets/vino-logo.png" alt="Vino Logo" />
                        </router-link>
                    </div>
                    <form @submit.prevent="" class="flex-grow">
                        <div class="relative">
                            <label class="relative flex items-center">
                                <input v-model="valeurRecherche" type="text" class="w-full py-1 pl-2 pr-[32px] rounded"
                                    placeholder="Recherchez une bouteille de la SAQ" @keyup="recherche">
                                <button class="material-symbols-outlined absolute right-0 p-1">
                                    search
                                </button>
                            </label>
                            <ul class="absolute mt-3 bg-white w-full rounded shadow z-10 transform transition-all duration-300" :class="{ 'transform -translate-y-1 opacity-0': rechercheVide, 'transform translate-y-0 opacity-100': !rechercheVide }">
                                <li class=" mx-4 flex" v-for="(bouteille, index) in bouteilles">
                                    <a href="#" class="pt-2 w-full text-left" :class="{ 'border-b-2': index !== bouteilles.length - 1 }">{{ bouteille.nom }}</a>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
import SaqProduitsDataService from "@/services/SaqProduitsDataService";

export default {
    name: "HeaderComponent",
    data() {
        return {
            menuMobile: false,
            valeurRecherche: "",
            tempsRecherche: null,
            rechercheVide: true,
            bouteilles: [],
        };
    },
    methods: {
        afficherMenu() {
            this.menuMobile = !this.menuMobile;
        },
        async recherche() {
            clearTimeout(this.tempsRecherche);

            this.tempsRecherche = setTimeout(async () => {
                if (this.valeurRecherche.length >= 3) {
                    console.log(this.valeurRecherche);
                    this.rechercheVide = false;

                    try {
                        const reponse = await SaqProduitsDataService.getBouteilles(this.valeurRecherche);
                        this.bouteilles = reponse.data;
                        console.log(this.bouteilles);
                    } catch (e) {
                        console.log(this.valeurRecherche);
                        console.log(e);
                    }
                }
            }, 500);
            
            if (this.valeurRecherche.length < 3) {
                this.rechercheVide = true;
                this.tempsRecherche = setTimeout(() => {
                    this.bouteilles = [];
                }, 500);
            }
        },
    },
    computed: {
        estConnecter() {
            console.log(this.$store.state.session.utilisateur_id);
            return this.$store.state.session.utilisateur_id !== undefined;
        },
    },
};
</script>

<style scoped>
/* Add any necessary styles here */
</style>
