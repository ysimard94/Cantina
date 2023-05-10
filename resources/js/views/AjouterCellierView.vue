<template>
    <div class="mx-auto my-5 max-w-md ml-4 mr-4">
        <div class="bg-bg-rose rounded-lg shadow-lg p-4 sm:p-6">
            <h1 class="text-xl font-medium mb-4 sm:text-3xl">Ajouter un nouveau cellier</h1>
            <div v-if="succesMessage" class="bg-green-100 text-green-700 p-2 mt-4 rounded">
                {{ succesMessage }}
            </div>
            <form @submit.prevent="ajouterCellier">
                <div class="mb-2 sm:mb-4">
                    <label class="block text-gray-700 font-medium mb-1 text-sm sm:text-lg">Nom du cellier</label>
                    <input type="text"
                        class="form-input rounded-md shadow-sm w-full py-2 px-3 sm:py-3 sm:px-4 text-sm sm:text-base"
                        v-model="cellier.nom" />
                </div>
                <div class="flex justify-center">
                    <button type="submit"
                        class="bg-vin-rouge hover:bg-vin-blanc text-white font-medium py-2 px-3 sm:py-3 sm:px-6 rounded-md shadow-sm text-sm sm:text-base">
                        Ajouter
                    </button>
                </div>
            </form>

        </div>
    </div>
</template>

<script>
import CellierDataService from '@/services/CellierDataService.js'

export default {
    name: 'AjouterCellierView',
    data () {
        return {
            cellier: {
                nom: '',
            },
            succesMessage: null
        }
    },
    methods: {
        ajouterCellier () {
            CellierDataService.ajouter(this.cellier)
                .then(response => {
                    this.succesMessage = 'Le cellier a été ajouté avec succès.'
                })
                .catch(error => {
                    console.log(error)
                })
        }
    }
}
</script>
