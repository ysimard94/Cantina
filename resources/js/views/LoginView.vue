<template>
    <section class="mt-12">
        <div class="bg-bg-rose m-4 p-3 shadow-md rounded">
            <form @submit.prevent="connexion">
                <h3 class="mb-4 text-vin-rouge font-bold text-xl">Connexion</h3>
                <p class="text-red-400">{{ message }}</p>
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
                        class="w-full rounded"
                    />
                </div>
                <div class="mb-4">
                    <label
                        for="mdp"
                        class="block text-lg text-left font-bold text-vin-rouge"
                        >Mot de passe</label
                    >
                    <input
                        type="password"
                        v-model="mdp"
                        id="mdp"
                        class="w-full rounded"
                    />
                </div>
                <div>
                    <button
                        type="submit"
                        class="mb-4 mt4 bg-vin-rouge text-vin-blanc rounded pt-1 pb-1 pr-5 pl-5"
                    >
                        Se Connecter
                    </button>
                </div>
            </form>
        </div>
    </section>
</template>

<script>
import AuthDataService from "@/services/AuthDataService";
export default {
    name: "LoginView",
    data() {
        return {
            courriel: "",
            mdp: "",
            message: "",
            utilisateur_id: "",
        };
    },
    methods: {
        connexion: async function () {
            console.log("connexion");
            await this.connecterUtilisateur();
        },
        connecterUtilisateur: async function () {
            this.$emit("loading:start");
            try {
                const reponse = await AuthDataService.connexion({
                    courriel: this.courriel,
                    mdp: this.mdp,
                });
                if (reponse.data.code === "courriel_non_trouvé") {
                    this.message = "Courriel non trouvé";
                } else if (reponse.data.code === "mot_de_passe_incorrect") {
                    this.message = "Mot de passe incorrect";
                } else {
                    this.$store.commit("setSession", {
                        key: "utilisateur_id",
                        value: reponse.data.utilisateur.id,
                    });
                    console.log(reponse.data.session);
                    localStorage.setItem("jwt-token", reponse.data.token);

                    this.$router.push({ name: "accueil" });
                }
            } catch (error) {
                console.error("Error fetching data:", error);
            } finally {
                // this.$store.dispatch("setLoading", false);
                this.$emit("loading:end");
            }
        },
    },
};
</script>
