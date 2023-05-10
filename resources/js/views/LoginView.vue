<template>
    <section class="mt-12">
        <div class="mb-12">
            <p class="text-vin-rouge text-3xl font-bold">Bienvenue sur Cantina</p>
        </div>
        <div class="bg-bg-rose m-4 p-3 shadow-md rounded">
            <form @submit.prevent="connexion">
                <h3 class="mb-4 text-vin-rouge font-bold text-xl">Connexion</h3>
                <!-- Erreurs serveur -->
                <p v-if="erreurServeur" class="block text-md text-red-500">
                    {{ erreurServeur }}
                </p>
                <div class="mb-4">
                    <label for="courriel" class="block text-lg text-left font-bold text-vin-rouge">Courriel</label>
                    <input type="text" v-model="courriel" id="courriel" class="w-full rounded pt-2 pb-2 pl-1 pr-1" :class="{
                        'border border-red-500':
                            v$.courriel.$error && v$.courriel.$dirty,
                        'border border-green-500':
                            !v$.courriel.$error && v$.courriel.$dirty,
                    }" />
                    <p v-if="v$.courriel.$error" class="block text-md text-red-500">
                        Veillez entrer un courriel valide
                    </p>
                </div>
                <div class="mb-4">
                    <label for="mdp" class="block text-lg text-left font-bold text-vin-rouge">Mot de passe</label>
                    <input type="password" v-model="mdp" id="mdp" class="w-full rounded pt-2 pb-2 pl-1 pr-1" :class="{
                        'border border-red-500':
                            v$.mdp.$error && v$.mdp.$dirty,
                        'border border-green-500':
                            !v$.mdp.$error && v$.mdp.$dirty,
                    }" />
                    <p v-if="v$.mdp.$error" class="block text-md text-red-500">
                        Veillez entrer un mot de passe valide
                    </p>
                </div>
                <div>
                    <button type="submit" class="mb-4 mt4 bg-vin-rouge text-vin-blanc rounded pt-1 pb-1 pr-5 pl-5">
                        Se Connecter
                    </button>
                </div>
            </form>
        </div>
        <div>
            <p>Pas de compte? <router-link :to="{ name: 'creer-utilisateur' }" class="underline text-blue-600">Inscris
                    toi!</router-link>
            </p>
        </div>
    </section>
</template>

<script>
import { useVuelidate } from "@vuelidate/core";
import { required, minLength, email } from "@vuelidate/validators";
import AuthDataService from "@/services/AuthDataService";
import { parse } from "postcss";
export default {
    name: "LoginView",
    setup () {
        return {
            v$: useVuelidate(),
        };
    },
    data () {
        return {
            courriel: "",
            mdp: "",
            utilisateur_id: "",
            erreurServeur: "",
        };
    },
    validations () {
        return {
            courriel: { required, email },
            mdp: { minLength: minLength(3) },
        };
    },
    methods: {
        connexion: async function () {
            this.v$.$touch(); // Déclenche la validation
            if (!this.v$.$invalid) {
                await this.connecterUtilisateur();
            }
        },
        connecterUtilisateur: async function () {
            this.$emit("loading:start");
            try {
                const reponse = await AuthDataService.connexion({
                    courriel: this.courriel,
                    mdp: this.mdp,
                });
                this.$store.commit("setSession", {
                    key: "utilisateur_id",
                    value: reponse.data.utilisateur.id,
                });
                localStorage.setItem("jwt-token", reponse.data.token);
                this.$router.push({ name: "mes-celliers" });
            }
            catch (error) {
                console.error("Error fetching data:", error);
                // Check if the error response contains an error message
                if (error.response &&
                    error.response.data &&
                    error.response.data.erreur) {
                    this.erreurServeur = error.response.data.erreur;
                }
                else {
                    this.erreurServeur =
                        "Une erreur inattendue s'est produite.";
                }
            }
            finally {
                this.$emit("loading:end");
            }
        },
    },
    components: { parse }
};
</script>
