<template>
    <!-- <div class="bg-bg_rose flex flex-col overflow-hidden shadow rounded-lg h-full" v-for="bouteille in bouteilles"
        :key="bouteille.id">
        <div class="flex items-start">
            <div class="w-1/3">
                <div class="relative ">
                    <div class="text-center text-white font-bold font-sans" :class="categorieBgColor(bouteille.categorie.nom)">
                  
                    
                    -->

    <div
        class="bg-bg_rose flex flex-col overflow-hidden shadow rounded-lg h-full"
        v-for="bouteille in bouteilles"
        :key="bouteille.id"
    >
        <div class="flex items-start">
            <div class="w-1/3">
                <div class="relative">
                    <div
                        class="text-center text-white font-bold"
                        :class="categorieBgColor(bouteille.categorie.nom)"
                    >
                        {{ bouteille.categorie.nom }}
                    </div>
                    <img
                        :src="bouteille.photo"
                        :alt="bouteille.nom"
                        class="w-2/3 mt-4 mb-4 mx-auto"
                    />
                </div>
            </div>

            <div class="px-4 pt-3 w-2/3 flex flex-col h-full">
                <h4
                    class="font-serif text-[15px] font-semibold text-vin-rouge text-left h-[67px] leading-tight"
                >
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
                                            <svg
                                                :class="{
                                                    'text-yellow-500':
                                                        bouteille.note / 20 >=
                                                        i,
                                                }"
                                                class="w-4 h-4 fill-current"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                            >
                                                <path
                                                    d="M10 15.95L4.43 19.7a.5.5 0 0 1-.74-.53l.98-5.71L.21 8.53a.5.5 0 0 1 .28-.85l5.75-.83L9.1 2.27a.5.5 0 0 1 .9 0l2.87 5.8 5.75.83a.5.5 0 0 1 .28.85l-4.45 4.35 1 5.71a.5.5 0 0 1-.74.53L10 15.95z"
                                                />
                                            </svg>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="pb-2 font-sans flex justify-end mt-2">
                            <router-link
                                v-if="!bouteille.code_saq"
                                :to="{
                                    name: 'modifier-bouteille',
                                    params: { id: bouteille.id },
                                }"
                            >
                                <button
                                    class="material-symbols-outlined w-10 h-10 rounded-lg text-white font-semibold bg-vin-blanc mr-2"
                                >
                                    edit
                                </button>
                            </router-link>

                            <div
                                v-if="bouteille.code_saq"
                                class="w-[32px] my-auto mr-2"
                            >
                                <img src="@assets/saq.svg" alt="SAQ Icon" />
                            </div>
                            <button
                                @click="supprimerBouteille(bouteille)"
                                class="material-symbols-outlined w-10 h-10 rounded-lg text-white font-semibold bg-vin-rouge ml-2"
                            >
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
