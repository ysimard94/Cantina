<template>
    <div class="container mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8 h-full">
            <div class="bg-bg_rose flex flex-col overflow-hidden shadow rounded-lg py-2 m-2 h-full"
                v-for="bouteille in bouteilles" :key="bouteille.id">

                <img :src="bouteille.photo" :alt="bouteille.nom" class="w-1/3 mx-auto">
                <div class="px-4 pt-4 flex flex-col justify-between">
                    <h4 class="text-lg font-serif font-semibold text-vin-rouge text-left h-[67px] leading-tight">{{
                        bouteille.nom }}</h4>
                    <div class="mt-4 flex justify-between items-center">
                        <div class="font-sans text-gray-700">
                            <div class="font-medium text-left"> {{ bouteille.pays.nom }}</div>
                            <div class="font-medium text-left">{{ bouteille.categorie.nom }}
                            </div>
                        </div>
                        <div>
                            <div class="text-gray-700 font-medium mr-2 text-right">Note </div>
                            <div class="flex items-center">

                                <div class="text-gray-600 font-medium text-right">{{ bouteille.note }}%({{
                                    bouteille.nbr_notes
                                }}
                                    avis)</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-auto">
                    <div class="pb-2 px-4 font-sans">
                        <div class="flex justify-center">
                            <button @click="ajouterAuCellier(bouteille)"
                                class="bg-vin_rouge rounded-md w-full text-sm text-vin_blanc hover:text-white focus:outline-none px-2 py-2">Ajouter</button>
                        </div>
                        <div class="my-2"></div>
                        <!--<div class="flex justify-center">
                            <button
                                class="bg-vin_rouge rounded-md w-full text-sm text-vin_blanc hover:text-white focus:outline-none px-2 py-2">Voir
                                plus</button>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="flex justify-center my-8">
                <pagination :current-page="currentPage" :total-pages="totalPages" @page-changed="onPageChanged"
                    :prev-text="'Préc'" :next-text="'Suiv'" :page-range="2" :margin-pages="1"
                    :container-class="'flex justify-center my-8'" class="mt-8 flex items-center justify-center"
                    :page-class="'rounded-full h-8 w-8 flex items-center justify-center bg-black text-gray-700 hover:bg-gray-100'"
                    :link-class="'block px-3 py-2 rounded-full hover:bg-gray-100'" :active-class="'bg-vin_rouge text-white'"
                    :disabled-class="'opacity-50 cursor-not-allowed'" />
            </div>

        </div>
    </div>
</template>

<script>

import axios from 'axios';
import Paginate from 'vuejs-paginate';
import BouteilleDataService from '@/services/BouteilleDataService';
import BouteilleCellierDataServive from '@/services/BouteilleCellierDataService';
export default {
    components: {
        Paginate
    },
    data() {
        return {
            bouteilles: [],

        }
    },
    computed: {
        totalPages() {
            return Math.ceil(this.bouteilles.length / this.pageSize);
        },
        paginatedBouteilles() {
            const startIndex = (this.currentPage - 1) * this.pageSize;
            return this.bouteilles.slice(startIndex, startIndex + this.pageSize);
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
                const response = await BouteilleCellierDataServive.ajouterBouteilleAuCellier(1, bouteille.id)
                console.log(response.data);
            } catch (error) {
                console.log(error);
            }
        },

    },
}
</script>
