<template>
    <!-- Animation qui change selon si l'utilisateur ferme le menu ou non -->
    <div
        :class="{
            'transform translate-x-full opacity-0': !menuOuvert,
            'transform translate-x-0 opacity-100': menuOuvert,
        }"
        class="fixed inset-0 transition-all duration-500 mb-[56px]"
    >
        <div class="w-full h-full bg-black bg-opacity-90 flex">
            <nav
                class="h-full w-full flex flex-col justify-center items-center"
            >
                <span class="mt-auto"></span>
                <router-link
                    v-if="this.$store.getters.isAdmin"
                    :to="{ name: 'saq-produits' }"
                    class="w-full text-2xl text-white py-2"
                    @click="fermerMenu"
                    >Obtenir les bouteilles SAQ</router-link
                >
                <router-link
                    :to="{ name: 'modifier-utilisateur' }"
                    class="w-full text-2xl text-white py-2"
                    @click="fermerMenu"
                    >Modifier profil</router-link
                >
                <router-link
                    :to="{ name: 'a-propos' }"
                    class="w-full text-2xl text-white py-2"
                    @click="fermerMenu"
                    >À propos</router-link
                >
                <router-link
                    :to="{ name: 'deconnexion' }"
                    class="w-full text-2xl text-white py-2 mb-auto"
                    @click="fermerMenu"
                    >Déconnexion</router-link
                >
            </nav>
        </div>
        <!-- Bouton pour fermer le menu -->
        <button
            :class="{
                'transform -rotate-180 opacity-0': !menuOuvert,
                'transform opacity-100': menuOuvert,
            }"
            class="material-symbols-outlined text-white text-6xl absolute top-5 left-5 transition-all duration-500"
            @click="
                fermerMenu();
                reinitialiserPage();
            "
        >
            close
        </button>
    </div>
</template>

<script>
export default {
    name: "MenuComponent",
    props: {
        menuOuvert: Boolean,
    },
    methods: {
        fermerMenu() {
            console.log(this.$store.getters.session);
            this.$emit("fermer-menu");
        },
        // Pour réinitialiser l'état de la page active à sa valeur initiale dans le footer
        reinitialiserPage() {
            this.$emit("reinitialiser-page");
        },
    },
};
</script>
