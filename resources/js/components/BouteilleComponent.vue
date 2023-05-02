<template>
    <div class="bg-bg_rose flex flex-col overflow-hidden shadow rounded-lg h-full" v-for="bouteille in bouteilles"
        :key="bouteille.id">
        <div class="flex items-start">
            <div class="w-1/3">
                <div class="relative ">
                    <div class="text-center text-white font-bold font-sans" :class="categorieBgColor(bouteille.categorie.nom)">
                        {{ bouteille.categorie.nom }}
                    </div>
                    <img :src="bouteille.photo" :alt="bouteille.nom" class="w-2/3 mt-4 mb-4 mx-auto " />

                </div>
            </div>
            <div class="px-4 pt-3 w-2/3 flex flex-col h-full">
                <h4 class="font-serif font-semibold text-vin-rouge text-left h-[67px] leading-tight">
                    {{ bouteille.nom }}
                </h4>
                <div class="text-sm mt-auto">
                    <div class="flex justify-between items-center">
                        <div class="font-sans text-gray-700">
                            <div class="font-medium text-left">
                                {{ bouteille.pays.nom }}
                            </div>
                            <div class="font-medium text-left">
                                Qté: {{ bouteille.pivot.quantite }}
                            </div>
                        </div>
                        <div>
                            <div class="text-gray-700 font-medium mr-2 text-right">
                                Note
                            </div>
                            <div class="flex items-center">
                                <div class="text-gray-600 font-medium text-right">
                                    ({{ bouteille.nbr_notes }} avis)
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="pb-2 font-sans flex justify-end mt-2">
                            <button v-if="!bouteille.code_saq"
                                class="material-symbols-outlined w-10 h-10 rounded-lg  text-white font-semibold bg-vin-blanc mr-2">
                                edit
                            </button>
                            <div v-if="bouteille.code_saq" class="w-[32px] my-auto mr-2">
                                <img src="@assets/saq.svg" alt="SAQ Icon" />
                            </div>
                            <button
                                class="material-symbols-outlined w-10 h-10 rounded-lg  text-white font-semibold bg-vin-rouge ml-2">
                                delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



<script>
import CellierDataService from "@/services/CellierDataService.js";
export default {

    name: 'BouteilleComponent',
    props: {
        bouteilles: {
            type: Object,
            required: true,
        },
    },

    methods: {
        async supprimerBouteille(bouteilleId) {
            try {
                await CellierDataService.supprimerBouteilleCellier(
                    this.cellierActif.id,
                    bouteilleId
                );
                this.bouteilles = this.bouteilles.filter(
                    (bouteille) => bouteille.id !== bouteilleId
                );
            } catch (error) {
                console.log(error);
            }
        },
        categorieBgColor(categorieNom) {
            switch (categorieNom) {
                case "Vin rouge":
                    return "bg-vin-rouge";
                case "Vin blanc":
                    return "bg-vin-blanc";
                case "Vin rosé":
                    return "bg-[#863D3D]";
                default:
                    return "bg-gray-500";
            }
        },
    }
}
</script>
