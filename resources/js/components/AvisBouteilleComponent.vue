<template>
    <div class="bg-gray-100 p-4 rounded-lg min-w-0">
        <div class="mt-4">
            <h3 class="text-lg font-bold mb-2">Avis récents</h3>
            <!--button pour ajouter un avis par l'utilisateur-->
            <button class="bg-vin-blanc text-white px-4 py-2 rounded-lg mb-2" @click="showForm = true">
                Ajouter un avis
            </button>
            <!-- formulaire pour ajouter un avis -->
            <form v-if="showForm" @submit.prevent="submitAvis">
                <div class="bg-white rounded-lg shadow p-4 mb-4 text-left">
                    <h3 class="text-m">Partagez votre expérience en laissant une note et un commentaire sur la bouteille !
                    </h3>
                    <div class="flex text-left mt-4">
                        <div v-for="i in 5" :key="i" class="mr-2">
                            <svg @click="setNote(i)" :class="{ 'text-vin-blanc': note >= i }"
                                xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 cursor-pointer" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M12 2 L15.09 8.09 L23 9.54 L17.91 15.5 L19.64 23.54 L12 20.59 L4.36 23.54 L6.09 15.5 L1 9.54 L8.91 8.09 L12 2 Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col text-left mt-4">
                        <label for="commentaire">Commentaire</label>
                        <textarea v-model="commentaire" id="commentaire" class="mt-2 bg-gray-200" rows="4"></textarea>
                    </div>
                    <div class="flex flex-row-reverse mt-4">
                        <button type="submit">
                            <span
                                class="material-symbols-outlined w-14 h-10 rounded-lg text-white font-semibold bg-vin-rouge flex items-center justify-center">
                                send
                            </span>
                        </button>
                        <button class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2" @click="annuler">
                            Annuler
                        </button>
                    </div>
                </div>
            </form>
            <!-- message de success-->
            <div v-else>
                <p v-if="avisAjoute" class="text-green-500 mb-2">Merci de nous avoir partagé votre expérience !</p>

            </div>
            <!-- Liste des avis -->
            <div v-for="review in avis.slice(0, limit)" :key="review.id"
                class="bg-white rounded-lg shadow p-4 mb-4 text-left">
                <p class="text-l font-bold mb-2">
                    {{ review.utilisateur.nom[0] + '***' + review.utilisateur.nom.slice(-1) }}

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
            <button v-if="limit < avis.length" class="bg-vin-rouge text-white px-4 py-2 rounded-lg mb-2"
                @click="limit += 3">
                Voir plus
            </button>
            <div v-if="!avis.length" class="bg-white rounded-lg shadow p-4 mb-4 text-left">
                <p class="text-vin-rouge text-center">Soyez la première personne à laisser un avis</p>
            </div>

        </div>

    </div>
</template>

<script>

import AvisDataService from "@/services/AvisDataService.js";
export default {
    name: "Avis",
    props: {
        bouteilleId: {
            type: Number,
            required: true
        }
    },
    data () {

        return {
            avis: [],
            note: 0,
            commentaire: '',
            showForm: false,
            avisAjoute: false,
            limit: 5
        };
    },
    created () {

        this.getAvisBouteille();
    },
    methods: {

        async getAvisBouteille () {
            // Récupérer les avis depuis l'API
            const reponse = await AvisDataService.avisBouteille(this.bouteilleId)
            this.avis = reponse.data.sort((a, b) => new Date(b.created_at) - new Date(a.created_at))
        },
        setNote (note) {
            this.note = note;
        },
        async submitAvis () {
            const data = {
                bouteille_id: this.bouteilleId, // remplacez par l'ID de la bouteille correspondante
                note: this.note,
                commentaire: this.commentaire,
            };
            try {
                const response = await AvisDataService.sendAvisBouteille(data);
            } catch (error) {
                console.error(error.response.data);
            }
            // Réinitialiser les données et fermer le formulaire
            this.note = 0;
            this.commentaire = '';
            this.showForm = false;
            this.avisAjoute = true;
            setTimeout(() => {
                this.avisAjoute = false;
            }, 3000);
            // Mettre à jour la liste des avis
            await this.getAvisBouteille();
        },
        annuler () {
            this.showForm = false;
            this.note = 0;
            this.commentaire = "";
        },

    },
};
</script>
