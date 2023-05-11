<template>
    <header class="shadow bg-vin-rouge">
        <div class="container mx-auto px-4 py-3 sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <div class="flex items-center w-full">
                    <!-- Logo -->
                    <div class="mx-auto">
                        <router-link
                            v-if="estConnecter"
                            class="flex-shrink-0 flex items-center"
                            :to="{ name: 'mes-celliers' }"
                        >
                            <img
                                class="max-h-[60px]"
                                src="@assets/logo.svg"
                                alt="Vino Logo"
                            />
                        </router-link>
                        <router-link
                            v-else
                            class="flex-shrink-0 flex items-center"
                            :to="{ name: 'connexion' }"
                        >
                            <img
                                class="max-h-[60px]"
                                src="@assets/logo.svg"
                                alt="Vino Logo"
                            />
                        </router-link>
                    </div>
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
                    this.rechercheVide = false;
                    try {
                        const reponse =
                            await SaqProduitsDataService.getBouteilles(
                                this.valeurRecherche
                            );
                        this.bouteilles = reponse.data;
                    } catch (e) {
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
        reinitialiserRecherche() {
            this.rechercheVide = true;
            this.valeurRecherche = "";
            this.tempsRecherche = setTimeout(() => {
                this.bouteilles = [];
            }, 500);
        },
    },
    computed: {
        estConnecter() {
            return this.$store.state.session.utilisateur_id !== undefined;
        },
    },
};
</script>

<style scoped>
/* Add any necessary styles here */
</style>
