<template>
    <section class="mt-8 flex flex-col gap-5 font-sans">
        <transition enter-active-class="transition duration-300 ease-out opacity-0" enter-class="opacity-0"
            enter-to-class="opacity-100" leave-active-class="transition duration-300 ease-in opacity-100"
            leave-class="opacity-100" leave-to-class="opacity-0">
            <!-- Message de succès -->
            <div v-if="estSuccessPopup" class="mx-6">
                <div class="bg-green-500 text-white font-bold rounded-full px-4 py-2 flex items-center">
                    <!-- Icône de succès (Google Material Icons) -->
                    <span class="material-icons text-lg mr-2">check_circle</span>
                    <span class="flex-1 text-center text-sm">{{
                        message
                    }}</span>
                    <button @click="fermerPopup" class="ml-2 material-symbols-outlined">
                        <!-- Icône de fermeture (Google Material Icons) -->
                        <span> close </span>
                    </button>
                </div>
            </div>
        </transition>
        <h1 class="text-5xl text-vin-rouge">Liste d'achats</h1>
        <!-- Si le tableau retourné est vide, montrer un message correspondant -->
        <template v-if="liste.length === 0">
            <p>Il n'y a aucune bouteille dans votre liste</p>
        </template>
        <!-- Sinon itérer à travers pour montrer les bouteilles dans la liste -->
        <template v-else>
            <ul class="flex flex-col gap-2">
                <li v-for="(liste, index) in liste" :key="liste.id">
                    <BouteilleListeComponent :index="index" :liste="liste" :celliers="celliers" @succesPopup="handleSuccesPopup" @supprimerBouteille="supprimerBouteille"/>
                </li>
            </ul>
        </template>
    </section>
</template>
  

<script>
import BouteilleDataService from "@/services/BouteilleDataService";
import CellierDataService from "@/services/CellierDataService.js";
import BouteilleListeComponent from "@/components/BouteilleListeComponent.vue";

export default {
    name: "ArchiveView",
    components: {
        BouteilleListeComponent,
    },
    data() {
        return {
            liste: [],
            celliers: [],
            userId: null,
            estSuccessPopup: false,
            message: "",
        };
    },
    methods: {
        async chargerListe() {
            try {
                const response =
                    await BouteilleDataService.getListeBouteilles(
                        this.$store.getters.session.utilisateur_id
                    );
                console.log(response.data.liste)
                this.liste = response.data.liste;
            } catch (error) {
                console.log(error);
            }
        },
        async fetchCelliers() {
            try {
                const response = await CellierDataService.getAll();
                this.celliers = response.data;
                console.log(this.celliers)
                // Si il est existe au moins un cellier, on mis le premier comme cellier actif
                if (this.celliers.length > 0) {
                    this.cellierActif = this.celliers[0];
                }
            } catch (error) {
                console.log(error.response);
            }
        },
        handleSuccesPopup(props) {
            this.message = props.message;
            this.estSuccessPopup = props.succes;
        },
        fermerPopup() {
            this.estSuccessPopup = false;
        },
        supprimerBouteille(listeId) {
            console.log(listeId)
            this.liste = this.liste.filter((liste) => liste.id !== listeId);
        }

    },
    async mounted() {
        //  Charger les archive de l'utilisateur
        await this.chargerListe();
        await this.fetchCelliers();
    },
};
</script>
