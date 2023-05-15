<template>
    <div class=" min-h-[162px] bg-bg_rose flex items-stretch overflow-hidden rounded-lg shadow mx-2">
        <!-- catégorie -->
        <div class="w-[12px]" :class="categorieBgColor(liste.bouteille.categorie.nom)"></div>
        <!-- Image -->
        <div class="w-[75px] flex items-center justify-center">
            <img :src="imageUrl(liste.bouteille)" :alt="liste.bouteille.nom" class="mx-auto" />
        </div>

        <div class="flex flex-1 flex-col items-center justify-between my-2 mx-2 font-sans text-sm">
            <!-- Titre -->
            <div class="w-full flex flex-col items-start gap-2">
                <router-link :to="{
                    name: 'bouteille-details',
                    params: { id: liste.bouteille.id },
                }">
                    <h4
                        class="w-[25ch] font-serif text-[15px] font-semibold text-vin-rouge text-left leading-tight underline">
                        {{ liste.bouteille.nom }}
                    </h4>
                </router-link>
                <span>
                    {{ liste.bouteille.pays.nom }}
                </span>
            </div>
            <div class="w-full flex justify-between" :class="{ 'flex-col': celliers.length >= 2 }">
                <!-- Pays -->
                <div fl>
                    <span class="text-left block">
                        Qté: {{ liste.quantite }}
                    </span>
                    <span class="text-left block text-lg">
                        $ {{ liste.bouteille.prix }}
                    </span>
                </div>
                <!-- Notes -->
                <div class="text-gray-700 font-medium mt-auto align-bottom p">
                    <div class="flex items-center">
                        <template v-if="celliers.length === 1">
                            <select id="cellier" hidden>
                                <option v-for="cellier in celliers" :key="cellier.id" :value="cellier.id">
                                </option>
                            </select>
                        </template>
                        <template v-else>
                            <select id="cellier"
                                class="p-2 font-sans w-full mr-2 rounded-md shadow-sm bg-slate-100 border-gray-300 border-2 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option disabled>Choisir un cellier</option>
                                <option v-for="cellier in celliers" :key="cellier.id" :value="cellier.id">
                                    {{ cellier.nom }}
                                </option>
                            </select>
                        </template>
                        <input type="hidden" :value="liste.quantite" id="quantite">
                        <button
                            class="material-symbols-outlined text-4xl ml-2 add-button transform transition-all hover:text-green-600 focus:text-green-600 hover:scale-125 active:scale-90"
                            @click="ajouterBouteille(liste.bouteille.id, $event, liste)">add</button>
                        <button
                            class="material-symbols-outlined text-4xl ml-2 add-button transform transition-all hover:text-red-600 focus:text-red-600 hover:scale-110 active:scale-90"
                            @click="supprimerBouteille(liste); messageSupprimer()">delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import BouteilleDataService from "@/services/BouteilleDataService.js";
export default {
    name: "BouteilleListeComponent",
    props: {
        liste: Array,
        celliers: Array,
    },
    methods: {
        // Retourne la date au format YYYY-MM-DD
        formatDate (dateString) {
            const date = new Date(dateString);
            return date.toISOString().split("T")[0];
        },
        // Retourne l'url de l'image de la bouteille en fonction de l'url de base
        imageUrl (bouteille) {
            const baseUrl = import.meta.env.VITE_BASE_URL || "";
            if (
                bouteille.photo !==
                "https://www.saq.com/media/catalog/product/1/4/14064101-1_1578550524.png?quality=80&fit=bounds&height=166&width=111&canvas=111:166" &&
                bouteille.code_saq === null
            ) {
                return `${baseUrl}${bouteille.photo}`;
            } else {
                return bouteille.photo;
            }
        },
        categorieBgColor (categorieNom) {
            switch (categorieNom) {
                case "Vin rouge":
                    return "bg-vin-rouge";
                case "Vin blanc":
                    return "bg-vin-blanc";
                case "Vin rosé":
                    return "bg-[#863D3D]";
                default:
                    return "bg-gray-500";
            }
        },
        async ajouterBouteille (bouteilleId, event, liste) {
            let cellierId = event.target.parentNode.querySelector("#cellier").value;

            try {
                const reponse = await BouteilleDataService.ajouterBouteilleAuCellier(cellierId, bouteilleId, 1);

                this.message = reponse.data.message
                this.$emit("succesPopup", {
                    succes: true,
                    message: this.message,
                });

                this.supprimerBouteille(liste)
                // Pour fermer le popup après 5 secondes
                setTimeout(() => {
                    this.message = "";
                    this.$emit("succesPopup", {
                        succes: false,
                        message: "",
                    });
                }, 5000);
            } catch (error) {
                console.log(reponse.data);
            }
        },
        async supprimerBouteille (liste) {
            try {
                if (liste.quantite >= 1) {
                    liste.quantite = liste.quantite - 1
                }
                if (liste.quantite === 0) {
                    this.$emit("supprimerBouteille", liste.id)
                }

                const reponse = await BouteilleDataService.supprimerBouteilleDeLaListe(liste.id, liste.quantite, liste.utilisateur_id);

                this.message = reponse.data.message
            } catch (error) {
                console.log(reponse.data);
            }
        },
        messageSupprimer () {
            this.$emit("succesPopup", {
                succes: true,
                message: "La bouteille a été supprimée avec succès",
            });
            // Pour fermer le popup après 5 secondes
            setTimeout(() => {
                this.message = "";
                this.$emit("succesPopup", {
                    succes: false,
                    message: "",
                });
            }, 5000);
        }
    },
};
</script>
