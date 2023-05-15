<template>
    <div class="h-[162px] bg-bg_rose flex items-stretch overflow-hidden rounded-lg shadow mx-2">
        <!-- catégorie -->
        <div class="w-[12px]" :class="categorieBgColor(archive.bouteille.categorie.nom)"></div>
        <!-- Image -->
        <div class="w-[75px] flex items-center justify-center">
            <img :src="imageUrl(archive.bouteille)" :alt="archive.bouteille.nom" class="mx-auto" />
        </div>

        <div class="flex flex-1 flex-col items-center justify-between my-2 mx-2 font-sans">
            <!-- Titre -->
            <div class="w-full flex flex-col items-start gap-2">
                <div class="w-full flex justify-between">
                    <router-link :to="{
                        name: 'bouteille-details',
                        params: { id: archive.bouteille.id },
                    }">
                        <h4
                            class="w-[25ch] flex font-serif text-[15px] font-semibold text-vin-rouge text-left leading-tight underline">
                            {{ archive.bouteille.nom }}
                        </h4>
                    </router-link>
                    <span v-if="archive.bouteille.code_saq" class="w-[25px] my-auto block">
                        <a :href="archive.bouteille.url_saq" target="_blank">
                            <img src="@assets/saq.svg" alt="SAQ Icon" />
                        </a>
                    </span>
                </div>
                <span>
                    {{ archive.bouteille.pays.nom }}
                </span>
            </div>
            <div class="w-full flex items-end justify-between">
                <!-- Pays -->
                <span class="text-left block">
                    Bu le <br />
                    {{ formatDate(archive.created_at) }}
                </span>
                <!-- Notes -->
                <div class="text-gray-700 font-medium mb-2">
                    <div class="flex items-center">
                        <template v-for="i in 5" :key="i">
                            <svg :class="{
                                'text-vin-blanc':
                                    archive.bouteille.note / 20 >= i,
                            }" class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path
                                    d="M12 2 L15.09 8.09 L23 9.54 L17.91 15.5 L19.64 23.54 L12 20.59 L4.36 23.54 L6.09 15.5 L1 9.54 L8.91 8.09 L12 2 Z" />
                            </svg>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "BouteilleComponentArchive",
    props: {
        archive: {
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
        getBouteille () {

        },

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
    },
    mounted () {
        setTimeout(() => {
            this.getBouteille();
        }, 500);
    },
};
</script>
