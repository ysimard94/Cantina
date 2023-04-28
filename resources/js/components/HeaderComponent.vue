<template>
    <header class="shadow">
        <nav class="bg-vin-rouge">
            <div class="container mx-auto px-4 py-3 sm:px-6 lg:px-8">
                <div class="flex justify-between">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="mr-4">
                            <router-link
                                v-if="estConnecter"
                                class="flex-shrink-0 flex items-center"
                                :to="{ name: 'mes-celliers' }"
                            >
                                <img
                                    class="max-w-[54px]"
                                    src="@assets/vino-logo.png"
                                    alt="Vino Logo"
                                />
                            </router-link>
                            <router-link
                                v-else
                                class="flex-shrink-0 flex items-center"
                                :to="{ name: 'connexion' }"
                            >
                                <img
                                    class="max-w-[54px]"
                                    src="@assets/vino-logo.png"
                                    alt="Vino Logo"
                                />
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        
        </nav>
    </header>
</template>

<script>
import AuthDataService from "@/services/AuthDataService";
import UtilisateurDataService from "@/services/UtilisateurDataService";
export default {
    name: "HeaderComponent",
    data() {
        return {
            menuMobile: false,
        };
    },
    methods: {
        afficherMenu() {
            this.menuMobile = !this.menuMobile;
        },
    },
    computed: {
        estConnecter() {
            console.log(this.$store.state.session.utilisateur_id);
            return this.$store.state.session.utilisateur_id !== undefined;
        },
    },
};
</script>

<style scoped>
/* Add any necessary styles here */
</style>
