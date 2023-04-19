<template>
    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-max w-full table-auto">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">#</th>
                    <th class="py-3 px-6 text-left">Nom</th>
                    <th class="py-3 px-6 text-left">Pays</th>
                    <th class="py-3 px-6 text-left">Catégorie</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <tr v-for="(bouteille, index) in bouteilles" :key="bouteille.id">
                    <td class="py-3 px-6 text-left">{{ index + 1 }}</td>
                    <td class="py-3 px-6 text-left">{{ bouteille.nom }}</td>
                    <td class="py-3 px-6 text-left">{{ bouteille.pays ? bouteille.pays.nom : '' }}</td>
                    <td class="py-3 px-6 text-left">{{ bouteille.categorie ? bouteille.categorie.nom : '' }}</td>
                    <td class="py-3 px-6 text-center">
                        <button @click="supprimerBouteille(bouteille.id)"
                            class="bg-vin_rouge hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Supprimer
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import BouteilleComponent from "@/components/BouteilleComponent.vue";
import CellierDataService from "@/services/CellierDataService.js";

export default {
    components: {
        'bouteille-card': BouteilleComponent
    },
    data() {
        return {
            bouteilles: []
        }
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
            console.log(bouteilleId)
            try {
                await CellierDataService.supprimerBouteilleCellier(1, bouteilleId);
               this.bouteilles = this.bouteilles.filter(bouteille => bouteille.id !== bouteilleId);
            } catch (error) {
                console.log(error);
            }
        }
    },
}
</script>
