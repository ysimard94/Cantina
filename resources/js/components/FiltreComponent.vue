<template>
    <button
        @click="montrerFiltre"
        class="px-2 py-1 rounded-md bg-vin_rouge text-white hover:bg-vin_blanc focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    >
        <i class="material-icons"> tune </i>
    </button>
    <!-- Filtre latéral -->
    <aside
        v-if="estOuvertFiltre"
        class="fixed inset-0 z-50 overflow-hidden flex"
    >
        <div class="relative w-full h-full bg-white overflow-y-scroll">
            <div class="px-4 py-4">
                <header class="flex justify-between items-center">
                    <button>
                        <i
                            @click="fermerFiltre"
                            class="material-icons text-3xl text-vin-rouge"
                        >
                            chevron_left
                        </i>
                    </button>

                    <h3 class="text-xl font-semibold text-vin-rouge">
                        Filtrer
                    </h3>
                    <button>
                        <span class="text-vin-rouge" @click="resetFilters"
                            >Réinitialiser</span
                        >
                    </button>
                </header>
                <!-- Barre de séparation  -->
                <div class="border-t border-gray-300 my-2 mb-4"></div>
                <!-- Source -->
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <h4 class="text-vin-rouge text-md font-semibold">
                            Sources
                        </h4>
                        <button @click="showSource = !showSource">
                            <i class="material-icons text-3xl text-vin-rouge">{{
                                expandIcon
                            }}</i>
                        </button>
                    </div>
                    <div v-show="showSource" class="flex gap-2 my-4">
                        <div
                            v-for="(source, index) in sources"
                            :key="index"
                            @click="toggleSource(index)"
                            :class="[
                                'flex',
                                'gap-2',
                                'items-center',
                                'justify-center',
                                'text-md',
                                'py-1',
                                'px-4',
                                'rounded-full',
                                'cursor-pointer',

                                selectedSources.includes(index)
                                    ? 'bg-vin-rouge hover:bg-vin-rouge'
                                    : 'bg-gray-200 hover:bg-gray-300',
                                selectedSources.includes(index)
                                    ? 'text-white'
                                    : 'text-vin-rouge',
                            ]"
                        >
                            <span>{{ source }}</span>
                            <span
                                class="material-icons text-xl"
                                :class="
                                    selectedSources.includes(index)
                                        ? 'text-white'
                                        : 'text-vin-rouge'
                                "
                            >
                                check
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Barre de séparation  -->
                <div class="border-t border-gray-300 mb-6"></div>
                <!-- Catégories -->
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <h4 class="text-vin-rouge text-md font-semibold">
                            Catégories
                        </h4>
                        <button
                            @click="showCategories = !showCategories"
                            class="text-vin-rouge flex items-center justify-center"
                        >
                            <i
                                class="ml-2 material-icons text-3xl text-vin-rou rouge"
                            >
                                {{
                                    showCategories
                                        ? "expand_less"
                                        : "expand_more"
                                }}
                            </i>
                        </button>
                    </div>
                    <div
                        v-show="showCategories"
                        class="flex flex-wrap gap-4 my-4"
                    >
                        <div
                            v-show="showCategories"
                            class="flex flex-wrap gap-4 my-4"
                        >
                            <div
                                v-for="(categorie, index) in categories"
                                :key="index"
                                @click="toggleCategorie(index)"
                                :class="[
                                    'flex',
                                    'gap-2',
                                    'items-center',
                                    'justify-center',
                                    'text-md',
                                    'py-1',
                                    'px-4',
                                    'rounded-full',
                                    'cursor-pointer',

                                    selectedCategories.includes(index)
                                        ? 'bg-vin-rouge hover:bg-vin-rouge'
                                        : 'bg-gray-200 hover:bg-gray-300',
                                    selectedCategories.includes(index)
                                        ? 'text-white'
                                        : 'text-vin-rouge',
                                ]"
                            >
                                <span>{{ categorie.nom }}</span>
                                <span
                                    class="material-icons text-xl"
                                    :class="
                                        selectedCategories.includes(index)
                                            ? 'text-white'
                                            : 'text-vin-rouge'
                                    "
                                >
                                    check
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Barre de séparation  -->
                <div class="border-t border-gray-300 mb-6"></div>
                <!-- Pays -->
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <h4 class="text-vin-rouge text-md font-semibold">
                            Pays
                        </h4>
                        <button
                            @click="showToutPays = !showToutPays"
                            class="text-vin-rouge flex items-center justify-center"
                        >
                            {{ showToutPays ? "Voir moins" : "Voir Tout" }}
                            <i
                                class="ml-2 material-icons text-3xl text-vin-rou rouge"
                            >
                                {{
                                    showToutPays ? "expand_less" : "expand_more"
                                }}
                            </i>
                        </button>
                    </div>
                    <div class="flex flex-wrap gap-4 my-4">
                        <div
                            v-for="(paysItem, index) in pays
                                ? pays
                                : pays.slice(0, 6)"
                            :key="index"
                            @click="togglePays(index)"
                            :class="[
                                'flex',
                                'gap-2',
                                'items-center',
                                'justify-center',
                                'text-md',
                                'py-1',
                                'px-4',
                                'rounded-full',
                                'cursor-pointer',

                                selectedPays.includes(index)
                                    ? 'bg-vin-rouge hover:bg-vin-rouge'
                                    : 'bg-gray-200 hover:bg-gray-300',
                                selectedPays.includes(index)
                                    ? 'text-white'
                                    : 'text-vin-rouge',
                            ]"
                        >
                            <span>{{ paysItem }}</span>
                            <span
                                class="material-icons text-xl"
                                :class="
                                    selectedPays.includes(index)
                                        ? 'text-white'
                                        : 'text-vin-rouge'
                                "
                            >
                                check
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Barre de séparation  -->
                <div class="border-t border-gray-300 mb-6"></div>
                <!-- Prix -->
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <h4 class="text-vin-rouge text-md font-semibold">
                            Prix
                        </h4>
                        <div
                            class="flex gap-2 items-center justify-center text-vin-rouge"
                        >
                            <div>
                                <input
                                    :style="{ width: inputPrixMinWidth }"
                                    type="text"
                                    v-model="prixMin"
                                />
                                <span>$</span>
                            </div>
                            <span> - </span>
                            <div>
                                <input
                                    :style="{ width: inputPrixMaxWidth }"
                                    type="text"
                                    v-model="prixMax"
                                />
                                <span>$</span>
                            </div>

                            <button
                                @click="showPrix = !showPrix"
                                class="text-vin-rouge flex items-center justify-center"
                            >
                                <i
                                    class="ml-2 material-icons text-3xl text-vin-rou rouge"
                                >
                                    {{
                                        showPrix ? "expand_less" : "expand_more"
                                    }}
                                </i>
                            </button>
                        </div>
                    </div>
                    <div v-show="showPrix">
                        <div class="flex my-4">
                            <label class="mr-4" for="prixMin">Min </label>
                            <input
                                type="range"
                                :min="defaultMin"
                                :max="defaultMax"
                                step="5"
                                v-model="prixMin"
                            />
                        </div>
                        <div class="flex">
                            <label class="mr-4" for="prixMax">Max </label>
                            <input
                                type="range"
                                :min="defaultMin"
                                :max="defaultMax"
                                step="5"
                                v-model="prixMax"
                            />
                        </div>
                    </div>
                </div>
                <!-- Barre de séparation  -->
                <div class="border-t border-gray-300 mb-6"></div>
                <!-- Notes -->
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="text-vin-rouge text-md font-semibold">
                            Notes
                        </h4>
                        <button
                            @click="showEtoiles = !showEtoiles"
                            class="text-vin-rouge flex items-center justify-center"
                        >
                            <i
                                class="ml-2 material-icons text-3xl text-vin-rou rouge"
                            >
                                {{
                                    showEtoiles ? "expand_less" : "expand_more"
                                }}
                            </i>
                        </button>
                    </div>
                    <div v-show="showEtoiles">
                        <div
                            v-for="line in 4"
                            :key="'line-' + line"
                            class="flex justify-start items-center"
                        >
                            <label
                                class="flex justify-start items-center"
                                :for="'option-' + line"
                            >
                                <i
                                    v-for="star in line"
                                    :key="'star-' + star"
                                    class="material-icons text-3xl text-vin-blanc"
                                >
                                    stars
                                </i>

                                <span class="text-vin-rouge mx-6"
                                    >& plus</span
                                ></label
                            >

                            <input
                                type="radio"
                                :id="'option-' + line"
                                :value="line"
                                v-model="nbrEtoileFiltrer"
                                class="ml-auto mr-2"
                            />
                        </div>
                    </div>
                </div>
                <!-- Barre de séparation  -->
                <div class="border-t border-gray-300 mb-6"></div>
                <!-- Validation -->
                <div class="mb-8">
                    <button
                        class="w-full bg-vin-rouge text-white py-2 px-4 rounded-full hover:bg-vin-rouge"
                    >
                        Voir ({{ resultatFiltre }}) résultats
                    </button>
                </div>
            </div>
        </div>
    </aside>
</template>

<script>
import CategorieDataService from "@/services/CategorieDataService.js";

export default {
    name: "FiltreComponent",
    props: {
        bouteilles: {
            type: [],
            required: true,
        },
    },
    data() {
        return {
            estOuvertFiltre: false,
            categories: [],
            selectedCategories: [],
            pays: [],
            selectedPays: [],
            sources: ["SAQ", "Personnalisée"],
            selectedSources: [],
            showToutPays: false,
            showCategorieFiltre: false,
            prixMin: "0",
            prixMax: "0",
            resultatFiltre: 0,
            nbrEtoileFiltrer: 4,
            showSource: true,
            showCategories: true,
            showPrix: true,
            showEtoiles: true,
            defaultMax: 1000,
            defaultMin: 0,
        };
    },
    computed: {
        inputPrixMinWidth() {
            return `${this.prixMin.length * 12}px`;
        },
        inputPrixMaxWidth() {
            return `${this.prixMax.length * 12}px`;
        },
        expandIcon() {
            return this.showSource ? "expand_less" : "expand_more";
        },
    },
    watch: {
        prixMin(newVal) {
            this.prixMax = newVal;
        },
    },
    methods: {
        fetchCategories: async function () {
            try {
                const reponse = await CategorieDataService.getAll();
                this.categories = reponse.data.categories;
            } catch (error) {
                console.error(error);
            } finally {
            }
        },
        extrairePays: function (bouteilles) {
            const paysSet = new Set(
                bouteilles.map((bouteille) => bouteille.pays.nom)
            );
            return Array.from(paysSet);
        },
        async montrerFiltre() {
            this.estOuvertFiltre = true;
            await this.fetchCategories();
            this.pays = this.extrairePays(this.bouteilles);
            console.log(this.categories);
        },
        toggleCategorie(index) {
            const selectedIndex = this.selectedCategories.indexOf(index);
            if (selectedIndex >= 0) {
                this.selectedCategories.splice(selectedIndex, 1);
            } else {
                this.selectedCategories.push(index);
            }
            console.log(this.selectedCategories);
        },
        toggleSource(index) {
            const selectedIndex = this.selectedSources.indexOf(index);
            if (selectedIndex >= 0) {
                this.selectedSources.splice(selectedIndex, 1);
            } else {
                this.selectedSources.push(index);
            }
            console.log(this.selectedSources);
        },
        togglePays(index) {
            const selectedIndex = this.selectedPays.indexOf(index);
            if (selectedIndex >= 0) {
                this.selectedPays.splice(selectedIndex, 1);
            } else {
                this.selectedPays.push(index);
            }
            console.log(this.selectedPays);
        },

        fermerFiltre() {
            this.estOuvertFiltre = false;
        },
        applyFilters() {
            this.estOuvertFiltre = false;
            // ... appliquez les filtres ...
        },
        resetFilters() {
            // ... réinitialisez les filtres ...
        },
    },
};
</script>

<style></style>
