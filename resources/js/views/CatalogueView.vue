<template>
    <div class="flex justify-center mx-2 my-4">
        <router-link
            to="/ajouter-bouteille"
            class="bg-vin_rouge rounded-md text-sm text-vin_blanc hover:text-white focus:outline-none px-4 py-2 mt-2 inline-block text-center w-full"
        >
            Ajouter une bouteille
        </router-link>
    </div>
    <div
        class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8 h-full"
    >
        <div
            class="bg-bg_rose flex flex-col overflow-hidden shadow rounded-lg py-2 m-2 h-full"
            v-for="bouteille in bouteilles"
            :key="bouteille.id"
        >
            <img
                :src="bouteille.photo"
                :alt="bouteille.nom"
                class="w-1/3 mx-auto"
            />
            <div class="px-4 pt-4 flex flex-col justify-between">
                <h4
                    class="text-lg font-serif font-semibold text-vin-rouge text-left h-[67px] leading-tight"
                >
                    {{ bouteille.nom }}
                </h4>
                <div class="mt-4 flex justify-between items-center">
                    <div class="font-sans text-gray-700">
                        <div class="font-medium text-left">
                            {{ bouteille.pays.nom }}
                        </div>
                        <div class="font-medium text-left">
                            {{ bouteille.categorie.nom }}
                        </div>
                    </div>
                    <div>
                        <div class="text-gray-700 font-medium mr-2 text-right">
                            Note
                        </div>
                        <div class="flex items-center">
                            <!--  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18.604,7.285c-0.21-0.651-0.84-1.104-1.538-1.104l-5.244-0.038L10.542,1.65c-0.357-0.72-1.402-0.72-1.758,0L7.634,6.143L2.39,6.181c-0.698,0-1.329,0.453-1.539,1.104c-0.21,0.652-0.033,1.366,0.484,1.776l3.813,3.416l-1.105,5.491c-0.105,0.518,0.121,1.039,0.556,1.311c0.436,0.272,0.974,0.246,1.368-0.07l4.722-2.871l4.724,2.872c0.163,0.099,0.341,0.147,0.518,0.147c0.334,0,0.661-0.148,0.883-0.427c0.435-0.272,0.661-0.793,0.556-1.311l-1.105-5.491l3.813-3.416C18.638,8.65,18.814,7.936,18.604,7.285z"/>
                        </svg>-->
                            <div class="text-gray-600 font-medium text-right">
                                {{ bouteille.note }}%({{ bouteille.nbr_notes }}
                                avis)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-auto">
                <div class="pb-2 px-4 font-sans">
                    <div class="flex justify-center">
                        <button
                            @click="ajouterAuCellier(bouteille)"
                            class="bg-vin_rouge rounded-md w-full text-sm text-vin_blanc hover:text-white focus:outline-none px-2 py-2"
                        >
                            Ajouter
                        </button>
                    </div>
                    <div class="my-2"></div>
                    <div class="flex justify-center">
                        <button
                            class="bg-vin_rouge rounded-md w-full text-sm text-vin_blanc hover:text-white focus:outline-none px-2 py-2"
                        >
                            Voir plus
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-center my-8">
            <pagination
                :current-page="currentPage"
                :total-pages="totalPages"
                @page-changed="onPageChanged"
                :prev-text="'Préc'"
                :next-text="'Suiv'"
                :page-range="2"
                :margin-pages="1"
                :container-class="'flex justify-center my-8'"
                class="mt-8 flex items-center justify-center"
                :page-class="'rounded-full h-8 w-8 flex items-center justify-center bg-black text-gray-700 hover:bg-gray-100'"
                :link-class="'block px-3 py-2 rounded-full hover:bg-gray-100'"
                :active-class="'bg-vin_rouge text-white'"
                :disabled-class="'opacity-50 cursor-not-allowed'"
            />
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Paginate from "vuejs-paginate";
import BouteilleDataService from "@/services/BouteilleDataService";
import BouteilleCellierDataServive from "@/services/BouteilleCellierDataService";
export default {
    components: {
        Paginate,
    },
    data() {
        return {
            bouteilles: [],
        };
    },
    computed: {
        totalPages() {
            return Math.ceil(this.bouteilles.length / this.pageSize);
        },
        paginatedBouteilles() {
            const startIndex = (this.currentPage - 1) * this.pageSize;
            return this.bouteilles.slice(
                startIndex,
                startIndex + this.pageSize
            );
        },
    },

    mounted() {
        this.fetchBouteilles();
        console.log(this.bouteilles);
    },
    methods: {
        async fetchBouteilles() {
            try {
                const response = await BouteilleDataService.getAll();
                this.bouteilles = response.data;
            } catch (error) {
                console.log(error);
            }
        },
        onPageChanged(pageNumber) {
            this.currentPage = pageNumber;
        },
        async ajouterAuCellier(bouteille) {
            try {
                const response =
                    await BouteilleCellierDataServive.ajouterBouteilleAuCellier(
                        1,
                        bouteille.id
                    );
                console.log(response.data);
            } catch (error) {
                console.log(error);
            }
        },
    },
};
</script>
