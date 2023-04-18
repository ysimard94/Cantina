<template>
    <header class="shadow">
        <nav class="bg-vin-rouge">
            <div class="container mx-auto px-4 py-3 sm:px-6 lg:px-8">
                <div class="flex justify-between">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="mr-4">
                            <router-link class="flex-shrink-0 flex items-center" :to="{ name: 'accueil' }">
                                <img class="h-8 w-auto" src="../../assets/vino-logo.png" alt="Vino Logo" />
                            </router-link>
                        </div>
                        <!-- Menu principal -->
                        <div class="hidden md:flex items-center space-x-5">
                            <router-link
                                class="nav-link md:inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-slate-100 hover:text-slate-400 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300"
                                :to="{ name: 'accueil' }">Accueil</router-link>
                            <router-link
                                class="nav-link md:inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-slate-100 hover:text-slate-400 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300"
                                :to="{ name: 'saq-produits' }">Obtenir produits SAQ</router-link>
                            <router-link
                                class="nav-link md:inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-slate-100 hover:text-slate-400 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300"
                                :to="{ name: 'connexion' }">Connexion</router-link>
                            <router-link
                                class="nav-link md:inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-slate-100 hover:text-slate-400 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300"
                                :to="{ name: 'nouvel-utilisateur' }">Créer un compte</router-link>
                        </div>
                    </div>
                    <!-- Bouton menu mobile -->
                    <div class="md:hidden flex ml-auto items-center">
                        <button @click="afficherMenu">
                            <img src="../../assets/hamburger-menu.png" alt="Bouton pour afficher menu mobile"
                                class="object-cover w-[40px]">
                        </button>
                    </div>
                    <!-- Barre de recherche -->
                    <div class="hidden md:ml-6 md:flex items-center">
                        <div class="flex items-center">
                            <form action="#" method="GET" class="relative">
                                <input type="search" name="search" placeholder="Search"
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:bg-white focus:placeholder-gray-600 focus:border-gray-300 focus:shadow-outline-blue sm:text-sm transition duration-150 ease-in-out" />
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center px-3 text-gray-300">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 2a8 8 0 100 16 8 8 0 000-16zM8 12a2 2 0 100-4 2 2 0 000 4zm6 0a2 2 0 100-4 2 2 0 000 4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </form>
                        </div>
                    </div> <!-- Fin barre de recherche -->
                </div>
            </div>
            <!-- Menu mobile -->
            <div v-show="menuMobile" class="md:hidden bg-bg-gris">
                <div class="flex flex-col justify-center">
                    <router-link
                        class=" text-black py-2 hover:bg-gray-200 border-b-2 border-gray-400 text-center justify-center"
                        :to="{ name: 'accueil' }">Accueil</router-link>
                    <router-link
                        class="text-black text-center hover:bg-gray-200 border-b-2 border-gray-400 py-2"
                        :to="{ name: 'saq-produits' }">Obtenir produits SAQ</router-link>
                    <router-link
                        class="text-black text-center hover:bg-gray-200 border-b-2 border-gray-400 py-2"
                        :to="{ name: 'connexion' }">Connexion</router-link>
                    <router-link
                        class="text-black text-center hover:bg-gray-200 py-2"
                        :to="{ name: 'nouvel-utilisateur' }">Créer un compte</router-link>
                </div>
            </div>
        </nav>
    </header>
</template>

<script>
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
};
</script>

<style scoped>
/* Add any necessary styles here */
</style>
