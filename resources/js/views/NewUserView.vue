<template>
    <section class="mt-12">
        <div class="bg-bg-rose m-4 p-3 shadow-md rounded">
            <form @submit.prevent="soumettre">
                <h3 class="mb-4 text-vin-rouge font-bold text-xl">Nouvelle Utilisateur</h3>
                <div class="mb-4">
                    <label for="nom" class="block text-lg text-left font-bold text-vin-rouge">Nom</label>
                    <input type="text" v-model="nom" id="nom" class="w-full rounded pt-3">
                </div>
                <div class="mb-4">
                    <label for="courriel" class="block text-lg text-left font-bold text-vin-rouge">Courriel</label>
                    <input type="text" v-model="courriel" id="courriel" class="w-full rounded pt-3">
                </div>
                <div class="mb-4">
                    <label for="mdp" class="block text-lg text-left font-bold text-vin-rouge">Mot de passe</label>
                    <input type="password" v-model="mdp" id="mdp" class="w-full rounded pt-3">
                </div>
                <div class="mb-4">
                    <label for="conf-mdp" class="block text-lg text-left font-bold text-vin-rouge">Confirmation du mot de passe</label>
                    <input type="password" v-model="conf_mdp" id="conf-mdp" class="w-full rounded pt-3">
                </div>
                <div>
                    <button type="submit" class="mb-4 mt-4 bg-vin-rouge text-vin-blanc rounded pt-1 pb-1 pr-5 pl-5">S'inscrire</button>
                </div>
            </form>
        </div>
    </section>
</template>

<script>

    export default {
        data() {
            return{
                nom: "",
                courriel: "",
                mdp: "",
                conf_mdp: ""
            }
        }
    }
    methods: {
        soumettre: () => {

        }
    }
</script>