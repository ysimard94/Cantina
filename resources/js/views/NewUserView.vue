<template>
    <section class="mt-12">
        <div class="bg-bg-rose m-4 p-3 shadow-md rounded">
            <form @submit.prevent="soumettre">
                <h3 class="mb-4 text-vin-rouge font-bold text-xl">Nouvelle Utilisateur</h3>
                <div class="mb-4">
                    <label for="nom" class="block text-lg text-left font-bold text-vin-rouge">Nom</label>
                    <input type="text" v-model="nom" id="nom" class="w-full rounded pt-2 pb-2 pl-1 pr-1">
                    <p v-if="v$.nom.$error" class="block text-md text-vin-rouge">Entrez un nom valide</p>
                </div>
                <div class="mb-4">
                    <label for="courriel" class="block text-lg text-left font-bold text-vin-rouge">Courriel</label>
                    <input type="text" v-model="courriel" id="courriel" class="w-full rounded pt-2 pb-2 pl-1 pr-1">
                    <p v-if="v$.courriel.$error" class="block text-md text-vin-rouge">Entrez un courriel valide</p>
                </div>
                <div class="mb-4">
                    <label for="mdp" class="block text-lg text-left font-bold text-vin-rouge">Mot de passe</label>
                    <input type="password" v-model="mdp" id="mdp" class="w-full rounded pt-2 pb-2 pl-1 pr-1">
                    <p v-if="v$.mdp.$error" class="block text-md text-vin-rouge">Entrez un mot de passe valide</p>
                </div>
                <div class="mb-4">
                    <label for="conf-mdp" class="block text-lg text-left font-bold text-vin-rouge">Confirmation du mot de passe</label>
                    <input type="password" v-model="conf_mdp" id="conf-mdp" class="w-full rounded pt-2 pb-2 pl-1 pr-1">
                    <p v-if="v$.conf_mdp.$error" class="block text-md text-vin-rouge">La confirmation est différente du mot de passe</p>
                </div>
                <div>
                    <button type="submit" class="mb-4 mt-4 bg-vin-rouge text-vin-blanc rounded pt-1 pb-1 pr-5 pl-5">S'inscrire</button>
                </div>
            </form>
        </div>
    </section>
</template>

<script>
import {useVuelidate} from '@vuelidate/core'
import { required, minLength, email, sameAs } from '@vuelidate/validators'
import AuthDataService from "@/services/AuthDataService";

export default {
    name: "NewUserView",
    setup(){
        return {
            v$: useVuelidate()
        }
    },
    data() {
        return {
            nom: "",
            courriel: "",
            mdp: "",
            conf_mdp: "",
        };
    },
    validations(){
        return {
            nom: required,
            nom: minLength(2),
            courriel: {required, email},
            mdp: minLength(3),
            conf_mdp: sameAs(this.mdp)
        }
    },
    methods: {
        soumettre: async function() {
            this.$emit("loading:start");
            try{
                const reponse = await AuthDataService.creation({
                    nom: this.nom,
                    courriel: this.courriel,
                    mdp: this.mdp,
                    conf_mdp: this.conf_mdp
                })
                if(reponse.status=== 201){
                    this.$router.push({name: "connexion"})
                }
            }catch(error){
                console.error(error)
            }finally {
                this.$emit("loading:end");
            }
        }
    }
}
</script>
