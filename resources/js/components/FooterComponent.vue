<template>
    <footer class="bg-vin-rouge bottom-0 w-full fixed">
        <div class="mx-auto z-50">
            <!-- Si l'utilisateur est connecté, montrer le menu de navigation -->
            <div class="flex justify-around" v-if="estConnecter">
                <router-link class="w-full" :to="{ name: 'mes-celliers' }">
                    <button :class="{ 'actif': pageActive === 0 }"
                        class="material-symbols-outlined text-white text-2xl px-5 py-3 w-full"
                        @click="fermerMenu(); changerPageActive(0)">
                        home
                    </button>
                </router-link>
                <router-link class="w-full" :to="{ name: 'modifier-utilisateur' }">
                    <button :class="{ 'actif': pageActive === 1 }"
                        class="material-symbols-outlined text-white text-2xl px-5 py-3 w-full"
                        @click=" fermerMenu(); changerPageActive(1)">
                        account_circle
                    </button>
                </router-link>
                <div class="w-20" :class="{ 'actif': pageActive === 1 }"></div>
                <button :class="{ 'bg-gray-700 rotate-45': pageActive === 2 }"
                    class="material-symbols-outlined bg-vin-blanc hover:bg-gray-700 text-white font-bold w-[68px] p-4 rounded-full transform transition-all duration-00 absolute bottom-0 text-3xl"
                    @click="afficherMenu(); changerPageActive(pageActive === 2 ? -1 : 2)">
                    add
                </button>
                <div class=" w-20" :class="{ 'actif': pageActive === 3 }"></div>
                <router-link class="w-full" 
                    :to="{
                    name: 'archive-bouteille',
                    params: {
                        utilisateurId: this.$store.getters.session.utilisateur_id,
                    },
                    }"
                >
                    <button :class="{ 'actif': pageActive === 3 }"
                        class="material-symbols-outlined text-white text-2xl px-5 py-3 w-full"
                        @click=" fermerMenu(); changerPageActive(3)">
                        menu_book
                    </button>
                </router-link>
                <!-- Si la page active est déjà celle-ci, le status de pageActive est réinitialisée à sa valeur initiale -->
                <button :class="{ 'actif': pageActive === 4 }"
                    class="material-symbols-outlined text-white text-2xl w-full"
                    @click="afficherMenu(); changerPageActive(pageActive === 4 ? -1 : 4)">
                    menu
                </button>
            </div>
            <!-- Sinon montrer le logo -->
            <img src="@assets/vino-logo.png" alt="Logo Vino" v-if="!estConnecter" class="w-[48px] py-3 m-auto">
        </div>
    </footer>
</template>

<script>
export default {
    name: "FooterComponent",
    props: {
        pageActive: Number,
    },
    computed: {
        estConnecter () {
            return this.$store.state.session.utilisateur_id !== undefined;
        },
    },
    methods: {
        afficherMenu () {
            this.$emit('toggle-menu')
        },
        fermerMenu () {
            this.$emit("fermer-menu");
        },
        changerPageActive (page) {
            this.$emit("changer-page-active", page);
        },
    },
};
</script>

<style scoped>
/* Add any necessary styles here */
.actif {
    background-color: #5c1b38;
    transition: background-color 300ms ease-in-out;
}
</style>
