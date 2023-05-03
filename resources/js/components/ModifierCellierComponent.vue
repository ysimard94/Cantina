<template>
    <div class="flex flex-col items-start space-y-4">
       <div v-if="errorMessage" class="bg-red-100 text-red-700 p-2 mt-4 rounded">
                {{ errorMessage }}
            </div>

        <form @submit.prevent="modifierCellier" class="flex items-center space-x-2">
            <input type="text" class="w-full border border-gray-300 rounded-md py-2 px-3" v-model="nouveauNom" />
            <button type="submit"
                class="material-symbols-outlined w-9 font-semibold text-white rounded-full bg-green-500 hover:bg-green-700">
                done
            </button>
            <button class="material-symbols-outlined w-9 font-semibold text-white rounded-full bg-red-500 hover:bg-red-700"
                @click="annulerModification">
                clear
            </button>
            <button type="button" class="material-symbols-outlined w-9 px-2 py-1 font-semibold text-vin-rouge"
                @click="supprimerCellier">
                delete
            </button>
        </form>
    </div>
</template>

<script>
import CellierDataService from '@/services/CellierDataService.js'

export default {
    name: 'ModifierCellierComponent',
    props: {
        cellier: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            nouveauNom: this.cellier.nom,
            successMessage: null,
            errorMessage: null
        }
    },
    methods: {
        async chargerCellier() {
            try {

                const response = await CellierDataService.details(this.cellier.id)
                this.cellier = response.data
            } catch (error) {
                console.log(error)
            }
        },
        async modifierCellier() {
            if (!this.nouveauNom.trim()) {
                this.errorMessage ='Le nom du cellier ne peut pas être vide.';
                return;
            }
            try {

                const cellier = { nom: this.nouveauNom }
                const response = await CellierDataService.modifier(this.cellier.id, cellier)
                console.log(response)
                this.successMessage = 'Le cellier a été modifié avec succès.'
                this.$emit('cellier-modifie', response.data)
                 this.$router.push({
                    name: 'mes-celliers',
                    query: {
                        message: this.successMessage
                    }
                 })
                 this.$emit('close');
            } catch (error) {
                console.log(error)
            }
        },
        async supprimerCellier() {
            try {
                const response = await CellierDataService.supprimer(this.cellier.id)
                console.log(response)
                this.successMessage = 'Le cellier a été supprimé avec succès.'
                this.$router.push({
                    name: 'mes-celliers',
                    query: {
                        message: this.successMessage
                    }
                })
                this.$emit('close');
                this.$emit('cellier-supprime')



            } catch (error) {
                console.log(error)
            }
        },
        annulerModification() {
            this.nouveauNom = this.cellier.nom;
            this.$emit('close');
        }
    },

    async created() {
        await this.chargerCellier()
    },
    watch: {
        cellier: function (nouvelleValeur) {
            this.nouveauNom = nouvelleValeur.nom;
        }
    }
}
</script>
