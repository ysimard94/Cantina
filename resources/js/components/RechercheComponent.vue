<template>
    <div :class="{
        'transform translate-y-5 opacity-0 -z-10': !rechercheOuverte,
        'transform translate-y-0 opacity-100': rechercheOuverte,
    }" class="flex w-full fixed bottom-[56px] mb-5 transition-all duration-300">
        <div class="flex flex-col mx-auto text-left bg-bg-rose w-full max-w-xl rounded shadow-md p-3 gap-2 font-sans">
            <form @submit.prevent="" class="flex-grow">
                <div class="relative">
                    <ul class="absolute mt-3 bg-white w-full rounded shadow z-10 transform transition-all duration-300 bottom-10"
                        :class="{
                            'transform translate-y-1 opacity-0':
                                rechercheVide,
                            'transform translate-y-0 opacity-100':
                                !rechercheVide,
                        }">
                        <li class="mx-4 flex text-left" :class="{
                            'border-b-2':
                                index !== bouteilles.length - 1,
                        }" v-for="(bouteille, index) in bouteilles" :key="index">
                            <router-link :to="{
                                name: 'resultat-recherche',
                                params: { valeur: bouteille.nom },
                            }" @click="reinitialiserRecherche(); reinitialiserPage();" class="pt-1">
                                {{ bouteille.nom }}
                            </router-link>
                        </li>
                    </ul>
                    <label class="relative flex items-center">
                        <input v-model="valeurRecherche" type="text" class="w-full py-1 pl-2 pr-[32px] rounded"
                            placeholder="Ajouter une bouteille de la SAQ" @keyup="recherche" @keyup.enter="goAuxResultats(valeurRecherche)"/>
                        <button class="material-symbols-outlined absolute right-0 p-1">
                            search
                        </button>
                    </label>
                </div>
            </form>
            <span>
                <router-link :to="{ name: 'ajouter-bouteille' }" @click="reinitialiserRecherche(); reinitialiserPage();"
                    class="text-vin-rouge border-b border-vin-rouge hover:text-red-700 ml-2">Ajouter votre propre
                    bouteille?</router-link>
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
                        const reponse = await SaqProduitsDataService.getBouteilles(this.valeurRecherche);
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
        reinitialiserPage() {
            this.$emit("reinitialiser-page");
        },
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
        rechercheOuverte(valeur) {
            if (!valeur) {
                this.reinitialiserRecherche();
            }
        },
    }
};
</script>
