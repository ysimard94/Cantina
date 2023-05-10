<template>
    <div class="container mx-auto h-screen flex flex-col justify-center items-center">
        <div v-show="isLoading" class="w-16 h-16">
            <LoadingSpinner />
        </div>
        <h1 v-show="!isLoading" class="text-xl font-serif font-semibold text-vin-rouge text-center mb-4">
            {{ message }}
        </h1>
    </div>
</template>

<script>
import SaqProduitsDataService from "@/services/SaqProduitsDataService";
import LoadingSpinner from "@/components/LoadingSpinner.vue";

export default {
    name: "SuccessView",
    components: {
        LoadingSpinner,
    },
    data () {
        return {
            message:
                "Veuillez patienter pendant que nous récupérons les données...",
            isLoading: true,
        };
    },
    methods: {
        // fetch le serveur et récupére les produit de la saq
        async fetchSaqProduits () {
            try {
                const reponse = await SaqProduitsDataService.getAll();
                this.message = reponse.data.message;
            } catch (error) {
                console.error(
                    "Erreur lors de la récupération des données:",
                    error
                );
                this.message =
                    "Une erreur s'est produite lors de la récupération des données.";
            } finally {
                this.isLoading = false;
            }
        },
    },
    async mounted () {
        await this.fetchSaqProduits();
    },
};
</script>

<style scoped></style>
