<template>
    <!-- <div class="bg-bg_rose flex flex-col overflow-hidden shadow rounded-lg h-full" v-for="bouteille in bouteilles"
        :key="bouteille.id">
        <div class="flex items-start">
            <div class="w-1/3">
                <div class="relative ">
                    <div class="text-center text-white font-bold font-sans" :class="categorieBgColor(bouteille.categorie.nom)">


                    -->

    <div class="bg-bg_rose flex flex-col overflow-hidden shadow rounded-lg h-full" v-for="bouteille in bouteilles"
        :key="bouteille.id">
        <div class="flex items-start">
            <div class="w-1/3">
                <div class="relative">
                    <div class="text-center text-white font-bold" :class="categorieBgColor(bouteille.categorie.nom)">
                        {{ bouteille.categorie.nom }}
                    </div>
                    <img :src="bouteille.photo" :alt="bouteille.nom" class="w-2/3 mt-4 mb-4 mx-auto" />
                </div>
            </div>

            <div class="px-4 pt-3 w-2/3 flex flex-col h-full">
                <h4 class="font-serif font-semibold text-vin-rouge text-left h-[67px] leading-tight">
                    <!--
                <div class="px-4 pt-4 w-2/3">
                    <h4
                        class="text-lg font-serif font-semibold text-vin-rouge text-left h-[67px] leading-tight"
                    >
                    -->

                    {{ bouteille.nom }}
                </h4>
                <div class="text-sm mt-auto">
                    <div class="flex justify-between items-center">
                        <div class="w-full font-sans text-gray-700">
                            <div class="font-medium text-left">
                                {{ bouteille.pays.nom }}
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="font-medium text-left">
                                    Qté: {{ bouteille.pivot.quantite }}
                                </div>
                                <!-- Notes -->
                                <div class="text-gray-700 font-medium mr-2">
                                    <div class="flex items-center">
                                        <template v-for="i in 5" :key="i">

                                            <svg :class="{ 'text-vin-blanc': bouteille.note / 20 >= i, }"
                                                class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M12 2 L15.09 8.09 L23 9.54 L17.91 15.5 L19.64 23.54 L12 20.59 L4.36 23.54 L6.09 15.5 L1 9.54 L8.91 8.09 L12 2 Z" />

                                            </svg>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div>
                            <div
                                class="text-gray-700 font-medium mr-2 text-right"
                            >
                                Note
                            </div>
                            <div class="flex items-center">
                                <div
                                    class="text-gray-600 font-medium text-right"
                                >
                                    ({{ bouteille.nbr_notes }} avis)
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div>
                        <div class="pb-2 font-sans flex justify-end mt-2">
                            <button v-if="!bouteille.code_saq" @click="modifierBouteille(bouteille)"
                                class="material-symbols-outlined w-10 h-10 rounded-lg text-white font-semibold bg-vin-blanc mr-2">
                                edit
                            </button>
                            <div v-if="bouteille.code_saq" class="w-[32px] my-auto mr-2">
                                <img src="@assets/saq.svg" alt="SAQ Icon" />
                            </div>
                            <button @click="supprimerBouteille(bouteille)"
                                class="material-symbols-outlined w-10 h-10 rounded-lg text-white font-semibold bg-vin-rouge ml-2">
                                delete
                            </button>
                        </div>

                        <!--<div class="flex items-center">Note
                        </div> #}-->
                    </div>
                </div>
                <!-- <div class="mt-auto">
                    <div class="pb-2 px-4 font-sans flex justify-center mt-2">
                        <router-link
                            :to="{
                                name: 'modifier-bouteille',
                                params: { id: bouteille.id },
                            }"
                        >
                            <button
                                v-if="!bouteille.code_saq"
                                class="material-symbols-outlined w-20 h-10 rounded-lg text-white font-semibold bg-vin-blanc mr-2"
                            >
                                edit
                            </button>
                        </router-link>
                        <div v-if="bouteille.code_saq">
                            <img
                                src="@assets/saq.svg"
                                alt="SAQ Icon"
                                class="w-20 h-10 rounded-lg text-white font-semibold mr-2"
                            />
                        </div>
                        <div class="w-2"></div>
                        <button
                            class="material-symbols-outlined w-20 h-10 rounded-lg text-white font-semibold bg-vin-rouge ml-2"
                            @click="supprimerBouteille(bouteille.id)"
                        >
                            delete
                        </button>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</template>

<script>
import CellierDataService from "@/services/CellierDataService.js";
export default {
    name: "BouteilleComponent",
    props: {
        bouteilles: {
            type: Object,
            required: true,
            default: () => [],
        },
        cellierId: {
            type: Number,
            required: true,
        },
    },

    methods: {
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
        async modifierBouteille(bouteille) {
            this.$emit("bouteille-supprime", bouteille);
        },

        async supprimerBouteille(bouteille) {
            this.$emit("bouteille-supprime", bouteille);
        },
    },
};
</script>
