<template>
    <section class="mt-12">
        <div class="bg-bg-rose m-4 p-3 shadow-md rounded">
            <transition
                enter-active-class="transform transition-all duration-300 ease-in"
                enter-class="transform translate-y-full opacity-0"
                enter-to-class="transform translate-y-0  opacity-100"
                leave-active-class="transform transition-all duration-300 ease-in"
                leave-class="transform translate-y-0  opacity-100"
                leave-to-class="transform translate-y-full  opacity-0"
            >
                <!-- Success Message -->
                <div
                    v-show="estSuccessPopup"
                    class="fixed bottom-0 left-0 right-0 flex justify-center mb-20 z-50"
                >
                    <div
                        class="bg-green-500 text-white font-bold rounded-lg px-4 py-2 flex items-center h-24 max-w-md shadow-lg w-full mx-2"
                    >
                        <!-- Success Icon (Google Material Icons) -->
                        <span class="material-icons text-lg mr-2"
                            >check_circle</span
                        >
                        <span class="flex-1 text-center text-sm">{{
                            message
                        }}</span>
                        <button
                            @click="fermerPopup"
                            class="ml-2 material-symbols-outlined"
                        >
                            <!-- Close Icon (Google Material Icons) -->
                            <span> close </span>
                        </button>
                    </div>
                </div>
            </transition>
            <form @submit.prevent="editUtilisateur">
                <h3 class="mb-4 text-vin-rouge font-bold text-xl">
                    Modifier Utilisateur
                </h3>
                <!-- Erreurs serveur -->
                <p v-if="erreurServeur" class="block text-md text-red-500">
                    {{ erreurServeur }}
                </p>

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
                        :class="{
                            'border border-red-500':
                                v$.nom.$error && v$.nom.$dirty,
                            'border border-green-500':
                                !v$.nom.$error && v$.nom.$dirty,
                        }"
                    />
                    <p
                        v-if="v$.nom.$error"
                        class="text-start pl-1 block text-xs text-red-500"
                    >
                        Veillez entrer un nom valide
                    </p>
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
                        :class="{
                            'border border-red-500':
                                v$.courriel.$error && v$.courriel.$dirty,
                            'border border-green-500':
                                !v$.courriel.$error && v$.courriel.$dirty,
                        }"
                    />
                    <p
                        v-if="v$.courriel.$error"
                        class="text-start pl-1 block text-xs text-red-500"
                    >
                        Veillez entrer un courriel valide
                    </p>
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
                        :class="{
                            'border border-red-500':
                                v$.mdp_courant.$error && v$.mdp_courant.$dirty,
                            'border border-green-500':
                                !v$.mdp_courant.$error && v$.mdp_courant.$dirty,
                        }"
                    />

                    <p
                        v-if="v$.mdp_courant.$error"
                        class="text-start pl-1 block text-xs text-red-500"
                    >
                        Veillez entrer un mot de passe valide
                    </p>
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
                        :class="{
                            'border border-red-500':
                                v$.mdp_nouveau.$error && v$.mdp_nouveau.$dirty,
                            'border border-green-500':
                                !v$.mdp_nouveau.$error && v$.mdp_nouveau.$dirty,
                        }"
                    />

                    <p
                        v-if="v$.mdp_nouveau.$error"
                        class="text-start pl-1 block text-xs text-red-500"
                    >
                        Veillez entrer un mot de passe valide
                    </p>
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
import { useVuelidate } from "@vuelidate/core";
import { required, minLength, email } from "@vuelidate/validators";

export default {
    name: "ModifierUtilView",
    async mounted() {
        const util = await this.getUtilisateur();
        this.nom = util.user.nom;
        this.courriel = util.user.courriel;
    },
    setup() {
        return {
            v$: useVuelidate(),
        };
    },
    data() {
        return {
            nom: "",
            courriel: "",
            mdp_courant: "",
            mdp_nouveau: "",
            erreurServeur: "",
            message: "",
            estSuccessPopup: false,
            timeoutInstance: null,
        };
    },
    // Ajouter les règles de validation
    validations: {
        nom: {
            required,
            minLength: minLength(2),
        },
        courriel: {
            required,
            email,
        },
        mdp_courant: {
            required,
            minLength: minLength(6),
        },
        mdp_nouveau: {
            minLength: minLength(6),
        },
    },
    methods: {
        // Fermer Le popup du message de succès
        fermerPopup() {
            clearTimeout(this.timeoutInstance);
            this.message = "";
            this.erreurServeur = "";
            this.estSuccessPopup = false;
        },
        // Obtenir le profil utilisateur
        getUtilisateur: async function () {
            try {
                const reponse = await UtilisateurDataService.getUtilisateur(
                    this.$store.state.session.utilisateur_id
                );
                return reponse.data;
            } catch (error) {
                console.error(error);
            }
        },
        // Mettre à jour le profil utilisateur
        editUtilisateur: async function () {
            // Déclenche la validation
            this.v$.$touch();
            // Si le formulaire est invalide, arrêtez le processus de soumission
            if (this.v$.$invalid) {
                this.erreurServeur = "";
                this.message = "";
                return;
            }
            this.$emit("loading:start");
            // Envoyer la requête pour modifié l'utilisateur
            try {
                const reponse = await UtilisateurDataService.editUtilisateur(
                    this.$store.state.session.utilisateur_id,
                    {
                        nom: this.nom,
                        courriel: this.courriel,
                        mdp_courant: this.mdp_courant,
                        mdp_nouveau:
                            this.mdp_nouveau !== "" ? this.mdp_nouveau : null,
                    }
                );

                if (reponse.data.erreur) {
                    this.erreurServeur = reponse.data.erreur;
                    console.log(this.erreurServeur);
                } else {
                    this.message = reponse.data.message;
                    this.estSuccessPopup = true;
                    // Pour fermer le popup après 5 secondes
                    this.timeoutInstance = setTimeout(() => {
                        this.message = "";
                        this.erreurServeur = "";
                        this.estSuccessPopup = false;
                    }, 2000);
                }
            } catch (error) {
                console.log(error);
                if (error.response && error.response.status === 422) {
                    this.erreurServeur = "Veuillez vérifier vos entrées.";
                } else {
                    this.erreurServeur = reponse.data.message;
                }
            } finally {
                this.$emit("loading:end");
            }
        },
    },
};
</script>
