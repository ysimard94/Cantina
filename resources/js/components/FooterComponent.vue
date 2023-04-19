<template>
    <footer class="bg-vin-rouge bottom-0 w-full">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between my-5">
                <div>
                    <h5 class="text-left font-bold text-lg text-vin-blanc font-serif">Navigation</h5>
                    <div class="flex flex-col font-sans text-left mt-3 text-slate-100 space-y-1">
                        <router-link 
                            class="text-slate-100 hover:text-slate-400"
                            :to="{ name: 'accueil' }">Accueil</router-link>
                        <router-link 
                            class="text-slate-100 hover:text-slate-400"
                            :to="{ name: 'saq-produits' }">Obtenir produits SAQ</router-link>
                    </div>
                </div>
                <div>
                    <router-link :to="{ name: 'accueil' }">
                        <img class="max-w-[70px]" src="../../assets/vino-logo.png" alt="Vino logo">
                    </router-link>
                </div>
                <div>
                    <h5 class="text-right font-bold text-lg text-vin-blanc font-serif">Membre</h5>
                    <div class="flex flex-col font-sans text-right mt-3 space-y-1">
                        <router-link 
                            class="text-slate-100 hover:text-slate-400"
                            :to="{ name: 'connexion' }" v-if="!estConnecter">Connexion</router-link>
                        <router-link 
                            class="text-slate-100 hover:text-slate-400"
                            :to="{ name: 'nouvel-utilisateur' } " v-if="!estConnecter">Créer un compte</router-link>
                        <router-link 
                            class="text-slate-100 hover:text-slate-400"
                            :to="{ name: 'modifierUtil', components:this.$store.state.session.utilisateur_id }" v-if="estConnecter">Modifier le profil</router-link>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-center justify-center">
                <div class="text-center text-white">
                    <p class="text-sm text-vin-blanc">© All rights reserved, VINO 2023</p>
                </div>
            </div>
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
};
</script>

<style scoped>
/* Add any necessary styles here */
</style>
