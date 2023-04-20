<template>
    <div class="container mx-auto px-2">
        <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
            <header class="bg-vin_blanc text-vin_rouge py-2 px-4">
                <h1 class="text-2xl font-serif font-semibold">Mon Cellier</h1>
            </header>

            <table class="w-full table-auto">
                <thead>
                    <tr
                        class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal"
                    >
                        <th class="text-left whitespace-normal px-4 py-3">
                            Nom
                        </th>
                        <th class="text-center px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <tr
                        v-for="bouteille in bouteilles"
                        :key="bouteille.id"
                        class="whitespace-normal"
                    >
                        <td class="text-left truncate max-w-[14rem] px-4 py-3">
                            {{ bouteille.nom }}
                        </td>
                        <td class="text-center px-4 py-3">
                            <button
                                @click="supprimerBouteille(bouteille.id)"
                                class="bg-vin_rouge hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Supprimer
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import BouteilleComponent from "@/components/BouteilleComponent.vue";
import CellierDataService from "@/services/CellierDataService.js";

export default {
    components: {
        "bouteille-card": BouteilleComponent,
    },
    data() {
        return {
            bouteilles: [],
        };
    },
    mounted() {
        this.fetchBouteillesCellier();
    },
    methods: {
        async fetchBouteillesCellier() {
            try {
                const response = await CellierDataService.BouteillesCellier(1);
                this.bouteilles = response.data;
            } catch (error) {
                console.log(error);
            }
        },
        async supprimerBouteille(bouteilleId) {
            console.log(bouteilleId);
            try {
                await CellierDataService.supprimerBouteilleCellier(
                    1,
                    bouteilleId
                );
                this.bouteilles = this.bouteilles.filter(
                    (bouteille) => bouteille.id !== bouteilleId
                );
            } catch (error) {
                console.log(error);
            }
        },
    },
};
</script>
