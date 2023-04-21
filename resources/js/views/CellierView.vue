<template>
    <div class="container mx-auto px-2">
        <div class="flex justify-center mx-2 my-4">
            <router-link
                to="/ajouter-bouteille"
                class="bg-vin_rouge rounded-md text-sm text-vin_blanc hover:text-white focus:outline-none px-4 py-2 mt-2 inline-block text-center w-full"
            >
                Ajouter une bouteille
            </router-link>
        </div>
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

                        <td class="flex flex-col text-center px-4 py-3">
                            <router-link
                                v-if="!bouteille.code_saq"
                                class="bg-vin_rouge hover:bg-gray-700 text-white font-bold py-2 px-4 rounded my-1"
                                :to="{
                                    name: 'modifier-bouteille',
                                    params: { id: bouteille.id },
                                }"
                            >
                                Modifier
                            </router-link>
                            <button
                                @click="supprimerBouteille(bouteille.id)"
                                class="bg-vin_rouge hover:bg-gray-700 text-white font-bold py-2 px-4 rounded my-1"
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
