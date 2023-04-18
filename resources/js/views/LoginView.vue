<template>
<<<<<<< HEAD
    <section>
        <div class="background">
            <form @submit.prevent="soumettre">
                <h3>Nouvelle Utilisateur</h3>
                <div>
                    <label for="nom">Nom</label>
                    <input type="text" v-model="name" id="nom" />
                </div>
                <div>
                    <label for="courriel">Courriel</label>
                    <input type="text" v-model="email" id="courriel" />
                </div>
                <div>
                    <label for="mdp">Mot de passe</label>
                    <input type="password" v-model="password" id="mdp" />
                </div>
                <div>
                    <label for="conf-mdp">Confirmation du mot de passe</label>
                    <input
                        type="password"
                        v-model="conf_password"
                        id="conf-mdp"
                    />
=======
    <section class="mt-12">
        <div class="bg-[#F0EBEB] m-4 p-3 shadow-md rounded">
            <form @submit.prevent="connexion">
                <h3 class="mb-4 text-vin_rouge font-bold text-xl">Connexion</h3>
                <div class="mb-4">
                    <label for="courriel" class="block text-md text-left font-bold text-vin_rouge">Courriel</label>
                    <input type="text" v-model="courriel" id="courriel" class="w-full rounded">
                </div>
                <div class="mb-4">
                    <label for="mdp" class="block text-md text-left font-bold text-vin_rouge">Mot de passe</label>
                    <input type="password" v-model="mdp" id="mdp" class="w-full rounded">
                </div>
                <div>
                    <button type="submit" class="mb-4 bg-vin_rouge text-vin_blanc rounded pt-1 pb-1 pr-5 pl-5">Se Connecter</button>
>>>>>>> upstream/main
                </div>
            </form>
        </div>
    </section>
</template>

<script>
<<<<<<< HEAD
export default {
    data() {
        return {
            name: "",
            email: "",
            password: "",
            conf_password: "",
        };
    },
};
methods: {
    soumettre: store();
}
</script>
=======

    export default {
        data() {
            return{
                courriel: "",
                mdp: "",
            }
        }
    }
    methods: {
        soumettre: () => {

        }
    }
</script>
>>>>>>> upstream/main
