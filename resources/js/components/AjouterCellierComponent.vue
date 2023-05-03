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

       async ajouterCellier() {
            try {
                if (!this.cellier.nom) {
                    // Si le champ nom est vide, afficher un message d'erreur et arrêter la méthode
                   this.succesMessage="Le champ 'Nom du cellier' ne peut pas être vide.";
                    return;
                }

                const response = await CellierDataService.ajouter(this.cellier);
                console.log(response.data.id)
                const nouveauCellier = { id:response.data.id , ...this.cellier };
                console.log(nouveauCellier);
                this.$emit('nouveau-cellier', nouveauCellier);
                this.succesMessage = 'Le cellier a été ajouté avec succès.';
                //window.location.reload();
            } catch (error) {
                console.log(error);
            }
        },

        annulerAjout() {
            this.$emit('close');
        },
    }
}
</script>
