<template>
    <div
        class="h-[162px] bg-bg_rose flex items-stretch overflow-hidden rounded-lg shadow mx-2"
    >
        <!-- catégorie -->
        <div
            class="w-[12px]"
            :class="categorieBgColor(liste.bouteille.categorie.nom)"
        ></div>
        <!-- Image -->
        <div class="w-[75px] flex items-center justify-center">
            <img
                :src="imageUrl(liste.bouteille)"
                :alt="liste.bouteille.nom"
                class="mx-auto"
            />
        </div>

        <div
            class="flex flex-1 flex-col items-center justify-between my-2 mx-2 font-sans"
        >
            <!-- Titre -->
            <div class="w-full flex flex-col items-start gap-2">
                <router-link
                    :to="{
                        name: 'bouteille-details',
                        params: { id: liste.bouteille.id },
                    }"
                >
                    <h4
                        class="w-[25ch] font-serif text-[15px] font-semibold text-vin-rouge text-left leading-tight underline"
                    >
                        {{ liste.bouteille.nom }}
                    </h4>
                </router-link>
                <span>
                    {{ liste.bouteille.pays.nom }}
                </span>
            </div>
            <div class="w-full flex justify-between">
                <!-- Pays -->
                <div>
                    <span class="text-left block">
                        Qté: {{ liste.quantite }}
                    </span>
                    <span class="text-left block text-lg">
                        $ {{ liste.bouteille.prix }}
                    </span>
                </div>
                <!-- Notes -->
                <div class="text-gray-700 font-medium mt-auto align-bottom">
                    <div class="flex items-center">
                        <button
                        class="material-symbols-outlined text-4xl ml-2 add-button transform transition-all hover:text-green-600 focus:text-green-600 hover:scale-125 active:scale-90"
                        @click="ajouterBouteille(bouteille.id, $event, bouteille.quantite)">add</button>
                        <button
                        class="material-symbols-outlined text-4xl ml-2 add-button transform transition-all hover:text-red-600 focus:text-red-600 hover:scale-110 active:scale-90"
                        @click="liste.bouteille.quantite - 1">delete</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "BouteilleListeComponent",
    props: {
        liste: {
            type: Object,
            required: true,
            default: () => [],
        },
        index: {
            type: Number,
            required: true,
            default: 0,
        },
    },
    methods: {
        getBouteille() {
            console.log(this.liste.bouteille.categorie.nom);
        },

        // Retourne la date au format YYYY-MM-DD
        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toISOString().split("T")[0];
        },
        // Retourne l'url de l'image de la bouteille en fonction de l'url de base
        imageUrl(bouteille) {
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
        categorieBgColor(categorieNom) {
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
    },
    mounted() {
        setTimeout(() => {
            this.getBouteille();
        }, 500);
    },
};
</script>
