<template>
    <div class="flex flex-col items-start space-y-4">
        <div v-if="errorMessage" class="bg-red-100 text-red-700 p-2 mt-4 rounded">
            {{ errorMessage }}
        </div>

        <form @submit.prevent="modifierCellier" class="flex items-center w-full">
            <input type="text" class="w-full border border-gray-300 rounded-md py-2 px-3 mr-2" v-model="nouveauNom" />
            <div class="flex items-center ml-auto">
                <button type="submit"
                    class="material-symbols-outlined mx-2 font-semibold text-white rounded-full bg-green-500 hover:bg-green-700 transform transition-all duration-200">
                    done
                </button>
                <button
                    class="material-symbols-outlined mx-2 font-semibold text-white rounded-full bg-red-500 hover:bg-red-700 transform transition-all duration-200"
                    @click="annulerModification">
                    clear
                </button>
                <button type="button" class="material-symbols-outlined w-9 py-1 font-semibold text-vin-rouge"
                    @click="supprimerCellier">
                    delete
                </button>
            </div>
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
    data () {
        return {
            nouveauNom: this.cellier.nom,
            successMessage: null,
            errorMessage: null
        }
    },
    methods: {
        async chargerCellier () {
            try {

                const response = await CellierDataService.details(this.cellier.id)
                this.cellier = response.data
            } catch (error) {
                console.log(error)
            }
        },
        async modifierCellier () {
            if (!this.nouveauNom.trim()) {
                this.errorMessage = 'Le nom du cellier ne peut pas être vide.';
                return;
            }
            try {

                const cellier = { nom: this.nouveauNom }
                const response = await CellierDataService.modifier(this.cellier.id, cellier)
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
        async supprimerCellier () {
            try {
                const response = await CellierDataService.supprimer(this.cellier.id)
                this.successMessage = 'Le cellier a été supprimé avec succès.'
                this.$router.push({
                    name: 'mes-celliers',
                    query: {
                        message: this.successMessage
                    }
                })
                this.$emit('close')
                this.$emit('cellier-supprime', this.cellier.id) // Émettre l'événement 'cellier-supprime' avec l'ID du cellier supprimé
            } catch (error) {
                console.log(error)
            }
        },

        annulerModification () {
            this.nouveauNom = this.cellier.nom;
            this.$emit('close');
        }
    },

    async created () {
        await this.chargerCellier()
    },
    watch: {
        cellier: function (nouvelleValeur) {
            this.nouveauNom = nouvelleValeur.nom;
        }
    }
}
</script>
