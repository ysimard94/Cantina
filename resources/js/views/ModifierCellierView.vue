<template>
    <div class="mx-auto my-5 max-w-md ml-4 mr-4">
        <div class="bg-bg-rose rounded-lg shadow-lg p-4 sm:p-6">
            <h1 class="text-xl font-medium mb-4 sm:text-3xl">Modifier le cellier "{{ cellier.nom }}"</h1>
             <div v-if="succesMessage" class="bg-green-100 text-green-700 p-2 mt-4 rounded">
                    {{ succesMessage }}
                  </div>
            <form @submit.prevent="modifierCellier">
                <div class="mb-2 sm:mb-4">
                    <label class="block text-gray-700 font-medium mb-1 text-sm sm:text-lg">Nom du cellier</label>
                    <input type="text"
                        class="form-input rounded-md shadow-sm w-full py-2 px-3 sm:py-3 sm:px-4 text-sm sm:text-base"
                        v-model="cellier.nom" />
                </div>
                <div class="flex justify-center">
                    <button type="submit"
                        class="bg-vin-rouge hover:bg-vin-blanc text-white font-medium py-2 px-3 sm:py-3 sm:px-6 rounded-md shadow-sm text-sm sm:text-base">
                        Enregistrer
                    </button>
                    <button type="button"
                            class="bg-vin-blanc hover:bg-vin-rouge text-gray-700 font-medium py-2 px-3 sm:py-3 sm:px-6 rounded-md shadow-sm text-sm sm:text-base ml-4"
                            @click="supprimerCellier">
                            Supprimer
                        </button>
                </div>
            </form>

        </div>
    </div>
</template>

<script>
import CellierDataService from '@/services/CellierDataService.js'

export default {
    name: 'ModifierCellierView',
    props: ['id'],
    data() {
        return {
            cellier: {
                nom: '',

            },
            succesMessage: null

        }
    },
    methods: {
        chargerCellier() {
            CellierDataService.details(this.id)
                .then(response => {
                    this.cellier = response.data
                })
                .catch(error => {
                    console.log(error)
                })
        },
        modifierCellier() {
            CellierDataService.modifier(this.id, this.cellier)
                .then(response => {
                    console.log(response)
                     this.succesMessage = 'Le cellier a été modifié avec succès.'
                })
                .catch(error => {
                    console.log(error)
                })
        },
        supprimerCellier() {
            if (confirm('Êtes-vous sûr de vouloir supprimer ce cellier?')) {
                CellierDataService.supprimer(this.id)
                    .then(response => {
                        console.log(response)
                        // rediriger vers la liste des celliers
                        this.$router.push('/celliers')
                    })
                    .catch(error => {
                        console.log(error)
                    })
            }
        }
    },
    created() {
        this.chargerCellier()
    }
}
</script>
