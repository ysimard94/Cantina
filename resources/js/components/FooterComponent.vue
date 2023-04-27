<template>
    <footer class="bg-vin-rouge bottom-0 w-full fixed">
        <div class="mx-auto z-50">
            <!-- Si l'utilisateur est connecté, montrer le menu de navigation -->
            <div class="flex justify-around" v-if="estConnecter">
                <router-link class="w-full" :to="{ name: 'mes-celliers' }">
                    <button class="material-symbols-outlined text-white text-5xl px-5 py-3 actif w-full">
                        home
                    </button>
                </router-link>
                <router-link class="w-full" :to="{ name: 'modifier-utilisateur' }">
                    <button class="material-symbols-outlined text-white text-5xl px-5 py-3 w-full">
                        account_circle
                    </button>
                </router-link>
                <button class="material-symbols-outlined text-white text-5xl w-full" @click="afficherMenu">
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
    computed: {
        estConnecter() {
            console.log(this.$store.state.session.utilisateur_id);
            return this.$store.state.session.utilisateur_id !== undefined;
        },
    },
    methods: {
        afficherMenu() {
            this.$emit('toggle-menu')
        },
    },
};
</script>

<style scoped>
/* Add any necessary styles here */
.actif {
    background-color: #5c1b38;
}
</style>
