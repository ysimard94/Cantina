<template>
    <div
        class="container mx-auto h-screen flex flex-col justify-center items-center"
    >
        <h1
            class="text-3xl font-serif font-semibold text-vin-rouge text-center mb-4"
        >
            404 - Page non trouvée
        </h1>
        <p class="text-lg font-sans text-gray-700 text-center mb-8">
            La page que vous recherchez n'existe pas ou a été déplacée.
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
};
</script>

<style scoped></style>
