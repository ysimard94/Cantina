<template>
    <section class="mt-12">
        <div class="mb-12">
            <p class="text-vin-rouge text-3xl font-bold">Rejoignez notre communauté d'amateur</p>
        </div>
        <div class="bg-bg-rose m-4 p-3 shadow-md rounded">
            <form @submit.prevent="soumettre">
                <h3 class="mb-4 text-vin-rouge font-bold text-xl">
                    Créer un compte
                </h3>
                <!-- Erreurs serveur -->
                <p v-if="erreurServeur" class="block text-md text-red-500">
                    {{ erreurServeur }}
                </p>
                <!-- Champ Nom -->
                <div class="mb-4">
                    <label for="nom" class="block text-lg text-left font-bold text-vin-rouge">Nom</label>
                    <input type="text" v-model="nom" id="nom" class="w-full rounded pt-2 pb-2 pl-1 pr-1" :class="{
                        'border border-red-500':
                            v$.nom.$error && v$.nom.$dirty,
                        'border border-green-500':
                            !v$.nom.$error && v$.nom.$dirty,
                    }" />
                    <p v-if="v$.nom.$error" class="block text-md text-red-500">
                        Entrez un nom valide
                    </p>
                </div>
                <!-- Champ Courriel -->
                <div class="mb-4">
                    <label for="courriel" class="block text-lg text-left font-bold text-vin-rouge">Courriel</label>
                    <input type="text" v-model="courriel" id="courriel" class="w-full rounded pt-2 pb-2 pl-1 pr-1" :class="{
                        'border border-red-500':
                            v$.courriel.$error && v$.courriel.$dirty,
                        'border border-green-500':
                            !v$.courriel.$error && v$.courriel.$dirty,
                    }" />
                    <p v-if="v$.courriel.$error" class="block text-md text-red-500">
                        Entrez un courriel valide
                    </p>
                </div>
                <!-- Champ Mot de passe -->
                <div class="mb-4">
                    <label for="mdp" class="block text-lg text-left font-bold text-vin-rouge">Mot de passe</label>
                    <input type="password" v-model="mdp" id="mdp" class="w-full rounded pt-2 pb-2 pl-1 pr-1" :class="{
                        'border border-red-500':
                            v$.mdp.$error && v$.mdp.$dirty,
                        'border border-green-500':
                            !v$.mdp.$error && v$.mdp.$dirty,
                    }" />
                    <p v-if="v$.mdp.$error" class="block text-md text-red-500">
                        Entrez un mot de passe valide
                    </p>
                </div>
                <!-- Champ Confirmation du mot de passe -->
                <div class="mb-4">
                    <label for="conf-mdp" class="block text-lg text-left font-bold text-vin-rouge">Confirmation du mot de
                        passe</label>
                    <input type="password" v-model.trim="mdp_confirmation" id="conf-mdp"
                        class="w-full rounded pt-2 pb-2 pl-1 pr-1" :class="{
                            'border border-red-500':
                                v$.mdp_confirmation.$error &&
                                v$.mdp_confirmation.$dirty,
                            'border border-green-500':
                                !v$.mdp_confirmation.$error &&
                                v$.mdp_confirmation.$dirty,
                        }" />
                    <p v-if="v$.mdp_confirmation.$error" class="block text-md text-red-500">
                        La confirmation est différente du mot de passe
                    </p>
                </div>
                <!-- Bouton Soumettre -->
                <div>
                    <button type="submit" class="mb-4 mt-4 bg-vin-rouge text-vin-blanc rounded pt-1 pb-1 pr-5 pl-5">
                        S'inscrire
                    </button>
                </div>
            </form>
        </div>
        <div>
            <p>Vous avez déjà un compte? <router-link :to="{ name: 'connexion' }"
                    class="underline text-blue-600">Connectez-vous!</router-link>
            </p>
        </div>
    </section>
</template>

<script>
import { useVuelidate } from "@vuelidate/core";
import { required, minLength, email, sameAs } from "@vuelidate/validators";
import AuthDataService from "@/services/AuthDataService";

export default {
    name: "NewUserView",
    setup () {
        return {
            v$: useVuelidate(),
        };
    },
    data () {
        return {
            nom: "",
            courriel: "",
            mdp: "",
            mdp_confirmation: "",
            erreurServeur: "",
        };
    },
    validations () {
        return {
            nom: { required, minLength: minLength(2) },
            courriel: { required, email },
            mdp: { minLength: minLength(3) },
            mdp_confirmation: {
                minLength: minLength(3),
                sameAsPassword: sameAs(this.mdp),
            },
        };
    },
    methods: {
        // Soumission du formulaire
        soumettre: async function () {
            this.v$.$touch(); // Déclenche la validation

            if (this.v$.$invalid) {
                // Si le formulaire est invalide, arrêtez le processus de soumission
                this.erreurServeur = "";
                return;
            }

            try {
                this.$emit("loading:start");
                await AuthDataService.creation({
                    nom: this.nom,
                    courriel: this.courriel,
                    mdp: this.mdp,
                    mdp_confirmation: this.mdp_confirmation,
                });
                this.$router.push({ name: "connexion" });
                this.erreurServeur = "";
            } catch (erreur) {
                this.erreurServeur = erreur.response.data.erreur;
            } finally {
                this.$emit("loading:end");
            }
        },
    },
};
</script>
