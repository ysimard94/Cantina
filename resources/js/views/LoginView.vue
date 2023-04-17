<template>
    <section>
        <div class="background">
            <form @submit.prevent="soumettre">
                <h3>Nouvelle Utilisateur</h3>
                <div>
                    <label for="nom">Nom</label>
                    <input type="text" v-model="name" id="nom">
                </div>
                <div>
                    <label for="courriel">Courriel</label>
                    <input type="text" v-model="email" id="courriel">
                </div>
                <div>
                    <label for="mdp">Mot de passe</label>
                    <input type="password" v-model="password" id="mdp">
                </div>
                <div>
                    <label for="conf-mdp">Confirmation du mot de passe</label>
                    <input type="password" v-model="conf_password" id="conf-mdp">
                </div>
            </form>
        </div>
    </section>
</template>

<script>

    export default {
        data() {
            return{
                name: "",
                email: "",
                password: "",
                conf_password: ""
            }
        }
    }
    methods: {
        soumettre: store()
    }
</script>