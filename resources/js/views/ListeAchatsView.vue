<template>
    <section class="mt-8 flex flex-col gap-5 font-sans">
      <h1 class="text-5xl text-vin-rouge">Liste d'achats</h1>
      <!-- Si le tableau retourné est vide, montrer un message correspondant -->
      <template v-if="liste.length === 0">
        <p>Il n'y a aucune bouteille dans votre liste</p>
      </template>
      <!-- Sinon itérer à travers pour montrer les bouteilles dans la liste -->
      <template v-else>
        <ul class="flex flex-col gap-2">
          <li v-for="(liste, index) in liste" :key="liste.id">
            <BouteilleListeComponent :index="index" :liste="liste" />
          </li>
        </ul>
      </template>
    </section>
  </template>
  

<script>
import BouteilleDataService from "@/services/BouteilleDataService";
import BouteilleListeComponent from "@/components/BouteilleListeComponent.vue";

export default {
    name: "ArchiveView",
    components: {
        BouteilleListeComponent,
    },
    data() {
        return {
            liste: [],
            userId: null,
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
    },
    async mounted() {
        //  Charger les archive de l'utilisateur
        await this.chargerListe();
    },
};
</script>
