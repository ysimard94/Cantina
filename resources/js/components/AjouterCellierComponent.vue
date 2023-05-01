<template>
    <div class="flex flex-col items-start space-y-4">
        <div v-if="succesMessage" class="bg-green-100 text-green-700 p-2 rounded">
            {{ succesMessage }}
        </div>

        <form @submit.prevent="ajouterCellier" class="flex items-center space-x-2">
            <input type="text" class="w-full border border-gray-300 rounded-md py-2 px-3" v-model="cellier.nom"
                placeholder="Nom du cellier" />

            <div class="w-4"></div>

            <button type="submit"
                class="material-symbols-outlined w-9  font-semibold text-white rounded-full bg-green-500 hover:bg-green-700">
                done
            </button>
             <button class="material-symbols-outlined w-9 font-semibold text-white rounded-full bg-red-500 hover:bg-red-700"
                    @click="annulerAjout">
                    clear
                </button>
        </form>
    </div>
</template>



<script>
import CellierDataService from '@/services/CellierDataService.js'

export default {
    name: 'AjouterCellierComponent',
    data() {
        return {
            cellier: {
                nom: '',
            },
            succesMessage: null
        }
    },
    methods: {
      async  ajouterCellier() {
          await  CellierDataService.ajouter(this.cellier)
                .then(response => {
                    this.$emit('nouveau-cellier', this.cellier)
                    this.succesMessage = 'Le cellier a été ajouté avec succès.'

                })
                .catch(error => {
                    console.log(error)
                })

        },
        annulerAjout() {

            this.$emit('close')

        },
    }
}
</script>
