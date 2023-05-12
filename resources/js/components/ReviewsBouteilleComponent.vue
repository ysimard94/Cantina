<template>
   <div class="bg-gray-100 p-4 rounded-lg min-w-0">
        <div class="mt-4">
            <h3 class="text-lg font-bold mb-2">Avis récents</h3>
            <div v-for="review in avis" :key="review.id" class="bg-white rounded-lg shadow p-4 mb-4 text-left">
                <p class="text-l font-bold mb-2">
                   {{ review.utilisateur.courriel.replace(review.utilisateur.courriel.split('@')[0].substr(1), '***') }}

                    <span class="text-yellow-500">
                        <!-- Ajouter autant d'étoiles jaunes que le nombre d'étoiles souhaité -->
                        <!-- Ajouter autant d'étoiles grises que le complément à 5 étoiles -->
                        <span v-for="i in 5" :key="i">
                            <template v-if="i <= review.note">
                                ★
                            </template>
                            <template v-else>
                                ☆
                            </template>
                        </span>
                    </span>
                </p>
                <p class="text-gray-700">{{ review.commentaire }}</p>

            </div>
     <div v-if="!avis.length" class="bg-white rounded-lg shadow p-4 mb-4 text-left">
            <p class="text-vin-rouge text-center">Soyez la première personne à laisser un avis</p>
          </div>
        </div>
    </div>

</template>

<script>

import BouteilleDataService from "@/services/BouteilleDataService.js";
export default {
    props: {
        bouteilleId: {
            type: Number,
            required: true
        }
    },
    data() {

        return {
            avis: []
        };
    },
    created() {

        this.getAvisBouteille();
    },
    methods: {
        async getAvisBouteille() {
            // Récupérer les avis depuis l'API
            const reponse = await BouteilleDataService.AvisBouteille(this.bouteilleId)
            this.avis = reponse.data
            console.log(this.avis)
        }

    },
};
</script>
