<template>
    <div class="container mx-auto">
        <div v-for="bouteille in bouteilles" :key="bouteille.id">
            <div class="bg-bg_rose overflow-hidden shadow rounded-lg px-2 py-2 m-4">

                <img :src="bouteille.photo" alt="Bottle image" class="w-16 h-32 object-cover mx-auto ">
                <div class="px-4 py-4">
                    <h4 class="text-lg font-semibold text-vin_rouge text-left font-serif">{{ bouteille.nom }}</h4>
                    <div class="text-left font-serif font-bold mt-2 text-lg">$ {{ bouteille.prix }}</div>
                    <div class="mt-2 flex justify-between items-center">
                        <div class="font-sans">
                            <div class="text-black font-medium text-left">{{ bouteille.pays.nom }}</div>
                            <div class="text-black font-medium text-left">{{ bouteille.categorie.nom }}</div>
                        </div>
                        <div class="flex mb-auto">
                            <template v-for="i in 5" :key="i">
                                <svg :class="{ 'text-vin-blanc': bouteille.note / 20 >= i, }" class="w-4 h-4 fill-current"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path
                                        d="M12 2 L15.09 8.09 L23 9.54 L17.91 15.5 L19.64 23.54 L12 20.59 L4.36 23.54 L6.09 15.5 L1 9.54 L8.91 8.09 L12 2 Z" />
                                </svg>
                            </template>
                        </div>
                    </div>
                </div>
                <p class="block text-md text-green-600">{{ bouteille.message }}</p>
                <div class="flex justify-between items-center mx-3 mb-3 hover:text-geen-600">
                    <select id="select-cellier"
                        class="p-2 font-sans w-full rounded-md shadow-sm bg-slate-100 border-gray-300 border-2 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option disabled>-- Sélectionner un cellier --</option>
                        <option v-for="(cellier) in celliers" :value="cellier.id" :key="cellier.id">{{ cellier.nom }}
                        </option>
                    </select>
                    <input type="number" :value="1" id="quantite"
                        class="p-2 font-sans rounded-md shadow-sm bg-slate-100 border-gray-300 border-2 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-[40px] w-16 ml-1"
                        placeholder="Quantité" min="1">
                    <button class="material-symbols-outlined text-4xl ml-2 add-button"
                        @click="ajouterBouteille(bouteille.id, $event, bouteille.quantite)">add</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import BouteilleDataService from "@/services/BouteilleDataService.js";
import CellierDataService from "@/services/CellierDataService.js";

export default {
    name: "ResultatView",
    data() {
        return {
            bouteilles: [],
            celliers: [],
            message: "",
            bouteille: {
                'quantite': 1,
            }
        };
    },
    methods: {
        async obtenirBouteille() {
            try {
                const reponse = await BouteilleDataService.getResultatsBouteilles(this.$route.params.valeur)
                this.bouteilles = reponse.data
                console.log(reponse.data)
            } catch (e) {
                console.log(e)
            }
        },
        async fetchCelliers() {
            try {
                const response = await CellierDataService.getAll();
                this.celliers = response.data;
                // Si il est existe au moins un cellier, on mis le premier comme cellier actif
                if (this.celliers.length > 0) {
                    this.cellierActif = this.celliers[0];
                }
                console.log(this.celliers)
            } catch (error) {
                console.log(error);
            }
        },
        handleChangerCellier() {
            console.log(this.cellierActif)
        },
        async ajouterBouteille(bouteilleId, event) {
            let cellierId = event.target.parentNode.querySelector("#select-cellier").value;
            let quantite = event.target.parentNode.querySelector("#quantite").value;
            try {
                const response = await BouteilleDataService.ajouterBouteilleAuCellier(cellierId, bouteilleId, quantite);
                console.log(response.data);
                const bouteilleAjoutee = this.bouteilles.find(bouteille => bouteille.id === bouteilleId);
                bouteilleAjoutee.message = response.data.message;
                setTimeout(() => {
                    bouteilleAjoutee.message = "";
                }, 3000);
            } catch (error) {
                console.log(reponse.data);
            }
        }
    },
    async mounted() {
        await this.fetchCelliers()
        this.obtenirBouteille()
    },
    // Va vérifier si la route a changé et refaire la requête si c'est le cas
    watch: {
        $route() {
            this.obtenirBouteille();
        },
    },
};
</script>
<style>
.add-button:hover {
    color: rgb(14, 168, 14);
}
</style>