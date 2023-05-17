<template>
    <footer class="bg-vin-rouge bottom-0 w-full fixed"  v-if="estConnecter">
        <div class="mx-auto z-50">
            <!-- Si l'utilisateur est connecté, montrer le menu de navigation -->
            <div class="flex justify-around">
                <!-- Navigation vers la page des celliers -->
                <router-link class="w-full" :to="{ name: 'mes-celliers' }">
                    <button :class="{ 'actif': pageActive === 0 }"
                        class="material-symbols-outlined text-white text-2xl px-5 py-3 w-full"
                        @click="fermerMenu(); changerPageActive(0);">
                        home
                    </button>
                </router-link>
                <!-- Navigation vers la liste d'achats -->
                <router-link class="w-full" :to="{
                    name: 'liste-achats',
                    params: {
                        utilisateurId: this.$store.getters.session.utilisateur_id,
                    },
                }">
                    <button :class="{ 'actif': pageActive === 1 }"
                    class="material-symbols-outlined text-white text-2xl px-5 py-3 w-full"
                    @click=" fermerMenu(); changerPageActive(1);">
                    feed
                </button>
            </router-link>
            <div class="w-20" :class="{ 'actif': pageActive === 1 }"></div>
            <!-- Ouvre la modale de recherche et d'ajout de bouteilles  -->
            <button :class="{
                'bg-gray-700 rotate-45': rechercheActive,
                'bg-vin-blanc': !rechercheActive,
            }"
                    class="material-symbols-outlined  hover:bg-gray-700 text-white font-bold w-[68px] p-4 rounded-full transform transition-all absolute bottom-0 text-3xl"
                    @click="afficherRecherche(); fermerMenu(); changerPageActive(pageActive === 4 ? -1 : pageActive)">
                    add
                </button>
                <div class=" w-20" :class="{ 'actif': pageActive === 3 }"></div>
                <!-- Navigation vers l'historique de bouteilles bues -->
                <router-link class="w-full" :to="{
                    name: 'archive-bouteille',
                    params: {
                        utilisateurId: this.$store.getters.session.utilisateur_id,
                    },
                }">
                    <button :class="{ 'actif': pageActive === 3 }"
                        class="material-symbols-outlined text-white text-2xl px-5 py-3 w-full"
                        @click=" fermerMenu(); changerPageActive(3);">
                        menu_book
                    </button>
                </router-link>
                <!-- Ouvre un menu secondaire avec les pages moins importantes -->
                <button :class="{ 'actif': pageActive === 4 }" class="material-symbols-outlined text-white text-2xl w-full"
                    @click="afficherMenu(); fermerRecherche(); changerPageActive(pageActive === 4 || pageActive === 2 ? -1 : 4); rechercheActive = false">
                    menu
                </button>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: "FooterComponent",
    props: {
        pageActive: Number,
        rechercheActive: Boolean,
    },
    computed: {
        // Pour vérifier si l'utilisateur est connecté
        estConnecter() {
            return this.$store.state.session.utilisateur_id !== undefined;
        },
    },
    methods: {
        // Va afficher le menu secondaire ou non
        afficherMenu() {
            this.$emit('toggle-menu')
        },
        // Va afficher la modale de recherche ou non
        afficherRecherche() {
            this.$emit('toggle-recherche')
        },
        // Va fermer le menu secondaire
        fermerMenu() {
            this.$emit("fermer-menu");
        },
        // Va fermer la modale de recherche
        fermerRecherche() {
            this.$emit("fermer-recherche");
        },
        // Va changer la page active
        changerPageActive(page) {
            this.$emit("changer-page-active", page);
        },
    },
};
</script>

<style scoped>
.actif {
    background-color: #5c1b38;
    transition: background-color 300ms ease-in-out;
}
</style>
