<template>
    <div class="container mx-auto">
        <div v-for="bouteille in bouteilles">
            <div class="bg-bg_rose overflow-hidden shadow rounded-lg px-2 py-2 m-4">
                <img :src="bouteille.photo" alt="Bottle image" class="w-16 h-32 object-cover mx-auto ">
                <div class="px-4 py-4">
                    <h4 class="text-lg font-semibold text-vin_rouge text-left">{{ bouteille.nom }}</h4>
                    <div class="mt-4 flex justify-between items-center">
                        <div>
                            <div class="text-black font-medium text-left">{{ bouteille.pays.nom }}</div>
                            <div class="text-black font-medium text-left">{{ bouteille.categorie.nom }}</div>
                        </div>
                        <div>
                            <div class="text-gray-700 font-medium mr-2 text-right">Note </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-1"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18.604,7.285c-0.21-0.651-0.84-1.104-1.538-1.104l-5.244-0.038L10.542,1.65c-0.357-0.72-1.402-0.72-1.758,0L7.634,6.143L2.39,6.181c-0.698,0-1.329,0.453-1.539,1.104c-0.21,0.652-0.033,1.366,0.484,1.776l3.813,3.416l-1.105,5.491c-0.105,0.518,0.121,1.039,0.556,1.311c0.436,0.272,0.974,0.246,1.368-0.07l4.722-2.871l4.724,2.872c0.163,0.099,0.341,0.147,0.518,0.147c0.334,0,0.661-0.148,0.883-0.427c0.435-0.272,0.661-0.793,0.556-1.311l-1.105-5.491l3.813-3.416C18.638,8.65,18.814,7.936,18.604,7.285z" />
                                </svg>
                                <div class="text-gray-400 font-medium text-right">4.5</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import BouteilleDataService from "@/services/BouteilleDataService.js";

export default {
    name: "ResultatView",
    data() {
        return {
            bouteilles: [],
        };
    },
    methods: {
        async obtenirBouteille() {
            try {
                const reponse = await BouteilleDataService.getResultatsBouteilles(this.$route.params.valeur)
                this.bouteilles = reponse.data
                console.log(reponse.data)
            } catch (e) {
                console.log(e)
            }
        },
    },
    mounted() {
        this.obtenirBouteille()
    },
    // Va vérifier si la route a changé et refaire la requête si c'est le cas
    watch: {
        $route() {
            this.obtenirBouteille();
        },
    },
};
</script>