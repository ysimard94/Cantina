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
                                <input 
                                    v-model="valeurRecherche" 
                                    type="text" 
                                    class="w-full py-1 pl-2 pr-[32px] rounded"
                                    placeholder="Recherchez une bouteille de la SAQ"
                                    @keyup="recherche"
                                >
                                <button class="material-symbols-outlined absolute right-0 p-1">
                                    search
                                </button>
                            </label>
                            <ul class="absolute mt-3 bg-white w-full rounded shadow z-10 transform transition-all duration-300" :class="{ 'transform -translate-y-1 opacity-0': rechercheVide, 'transform translate-y-0 opacity-100': !rechercheVide }">
                                <li 
                                    class=" mx-4 flex" 
                                    
                                    v-for="(bouteille, index) in bouteilles" 
                                    >
                                    <router-link 
                                        :to="{ name: 'resultat-recherche', params: { valeur: bouteille.nom } }"
                                        @click="reinitialiserRecherche()"
                                        class="pt-1">
                                        {{ bouteille.nom }}
                                    </router-link>
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
            clearTimeout(this.tempsRecherche)

            this.tempsRecherche = setTimeout(async () => {
                if (this.valeurRecherche.length >= 3) {
                    this.rechercheVide = false
                    try {
                        const reponse = await SaqProduitsDataService.getBouteilles(this.valeurRecherche)
                        this.bouteilles = reponse.data
                    } catch (e) {
                        console.log(e)
                    }
                }
            }, 500);
            if (this.valeurRecherche.length < 3) {
                this.rechercheVide = true
                this.tempsRecherche = setTimeout(() => {
                    this.bouteilles = []
                }, 500)
            }
        },
        reinitialiserRecherche() {
            this.rechercheVide = true
            this.valeurRecherche = ""
            this.tempsRecherche = setTimeout(() => {
                this.bouteilles = []
            }, 500)
        },
    },
    computed: {
        estConnecter() {
            return this.$store.state.session.utilisateur_id !== undefined
        },
    },
};
</script>

<style scoped>
/* Add any necessary styles here */
</style>
