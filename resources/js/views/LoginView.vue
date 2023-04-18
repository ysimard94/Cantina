<template>
    <section class="mt-12">
        <div class="bg-bg-rose m-4 p-3 shadow-md rounded">
            <form @submit.prevent="connexion">
                <h3 class="mb-4 text-vin-rouge font-bold text-xl">Connexion</h3>
                <div class="mb-4">
                    <label for="courriel" class="block text-lg text-left font-bold text-vin-rouge">Courriel</label>
                    <input type="text" v-model="courriel" id="courriel" class="w-full rounded">
                </div>
                <div class="mb-4">
                    <label for="mdp" class="block text-lg text-left font-bold text-vin-rouge">Mot de passe</label>
                    <input type="password" v-model="mdp" id="mdp" class="w-full rounded">
                </div>
                <div>
                    <button type="submit" class="mb-4 mt4 bg-vin-rouge text-vin-blanc rounded pt-1 pb-1 pr-5 pl-5">Se Connecter</button>
                </div>
            </form>
        </div>
    </section>
</template>

<script>

    export default {
        data() {
            return{
                courriel: "",
                mdp: "",
            }
        }
    }
    methods: {
        connexion: () => {

        }
    }
</script>