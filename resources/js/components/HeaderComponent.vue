<template>
    <header class="shadow bg-vin-rouge">
        <div class="container mx-auto px-4 py-3 sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <div class="flex items-center w-full">
                    <!-- Logo -->
                    <div class="mx-auto">
                        <router-link
                            v-if="estConnecter"
                            class="flex-shrink-0 flex items-center"
                            :to="{ name: 'mes-celliers' }"
                        >
                            <img
                                class="max-h-[60px]"
                                src="/assets/logo.svg"
                                alt="Vino Logo"
                            />
                        </router-link>
                        <router-link
                            v-else
                            class="flex-shrink-0 flex items-center"
                            :to="{ name: 'connexion' }"
                        >
                            <img
                                class="max-h-[60px]"
                                src="/assets/logo.svg"
                                alt="Vino Logo"
                            />
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
export default {
    name: "HeaderComponent",
    computed: {
        // Vérifie si l'utilisateur est connecté
        estConnecter() {
            return this.$store.state.session.utilisateur_id !== undefined;
        },
    },
};
</script>
