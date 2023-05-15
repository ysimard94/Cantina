<template>
    <div
        class="container mx-auto h-screen flex flex-col justify-center items-center"
    >
        <h1
            class="text-3xl font-serif font-semibold text-vin-rouge text-center mb-4"
        >
            {{ errorTitle }}
        </h1>
        <p class="text-lg font-sans text-gray-700 text-center mx-2 mb-8">
            {{ errorMessage }}
        </p>
        <router-link
            :to="{ name: 'accueil' }"
            class="bg-vin_rouge rounded-md text-sm text-vin_blanc hover:text-white focus:outline-none px-4 py-2 inline-block text-center"
        >
            Retour à l'accueil
        </router-link>
    </div>
</template>

<script>
export default {
    name: "PageNonTrouveView",
    props: {
        errorType: {
            type: String,
            default: "404", // default value
        },
    },
    computed: {
        errorTitle() {
            return this.errorType === "404"
                ? "404 - Page non trouvée"
                : "403 - Accès refusé";
        },
        errorMessage() {
            return this.errorType === "404"
                ? "La page que vous recherchez n'existe pas ou a été déplacée."
                : "Vous n'avez pas l'autorisation d'accéder à cette page.";
        },
    },
};
</script>

<style scoped></style>
