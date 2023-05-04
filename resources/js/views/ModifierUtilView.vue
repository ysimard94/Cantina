<template>
    <section class="mt-12">
        <div class="bg-bg-rose m-4 p-3 shadow-md rounded">
            <form @submit.prevent="editUtilisateur">
                <h3 class="mb-4 text-vin-rouge font-bold text-xl">
                    Modifier Utilisateur
                </h3>
                <div class="mb-4">
                    <label
                        for="nom"
                        class="block text-lg text-left font-bold text-vin-rouge"
                        >Nom</label
                    >
                    <input
                        type="text"
                        v-model="nom"
                        id="nom"
                        class="w-full rounded pt-2 pb-2 pl-1 pr-1"
                    />
                </div>
                <div class="mb-4">
                    <label
                        for="courriel"
                        class="block text-lg text-left font-bold text-vin-rouge"
                        >Courriel</label
                    >
                    <input
                        type="text"
                        v-model="courriel"
                        id="courriel"
                        class="w-full rounded pt-2 pb-2 pl-1 pr-1"
                    />
                </div>
                <div class="mb-4">
                    <label
                        for="mdp"
                        class="block text-lg text-left font-bold text-vin-rouge"
                        >Ancien Mot de passe</label
                    >
                    <input
                        type="password"
                        v-model="mdp_courant"
                        id="mdp"
                        class="w-full rounded pt-2 pb-2 pl-1 pr-1"
                    />
                </div>
                <div class="mb-4">
                    <label
                        for="conf-mdp"
                        class="block text-lg text-left font-bold text-vin-rouge"
                        >Nouveau Mot de passe</label
                    >
                    <input
                        type="password"
                        v-model="mdp_nouveau"
                        id="conf-mdp"
                        class="w-full rounded pt-2 pb-2 pl-1 pr-1"
                    />
                </div>
                <div>
                    <button
                        type="submit"
                        class="mb-4 mt-4 bg-vin-rouge text-vin-blanc rounded pt-1 pb-1 pr-5 pl-5"
                    >
                        Modifier
                    </button>
                </div>
            </form>
        </div>
    </section>
</template>

<script>
import UtilisateurDataService from "@/services/UtilisateurDataService";

export default {
    name: "ModifierUtilView",
    async mounted() {
        const util = await this.getUtilisateur();
        console.log(util.user);
        this.nom = util.user.nom;
        this.courriel = util.user.courriel;
    },
    data() {
        return {
            nom: "",
            courriel: "",
            mdp_courant: "",
            mdp_nouveau: "",
        };
    },
    methods: {
        getUtilisateur: async function () {
            // this.$emit("loading:start");
            try {
                const reponse = await UtilisateurDataService.getUtilisateur(
                    this.$store.state.session.utilisateur_id
                );
                return reponse.data;
            } catch (error) {
                console.error(error);
            } finally {
                // this.$emit("loading:end");
            }
        },
        editUtilisateur: async function () {
            this.$emit("loading:start");
            try {
                const reponse = await UtilisateurDataService.editUtilisateur(
                    this.$store.state.session.utilisateur_id,
                    {
                        nom: this.nom,
                        courriel: this.courriel,
                        mdp_courant: this.mdp_courant,
                        mdp_nouveau: this.mdp_nouveau,
                    }
                );
                console.log(reponse.data.message);
            } catch (error) {
                console.error(error);
            } finally {
                this.$emit("loading:end");
            }
        },
    },
};
</script>
