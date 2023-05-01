<template>
    <aside>
        <div class="relative w-full h-full bg-white overflow-y-scroll">
            <header class="flex justify-between items-center px-4 py-4">
                <button>
                    <i
                        @click="fermerFiltre"
                        class="material-icons text-3xl text-vin-rouge"
                    >
                        chevron_left
                    </i>
                </button>

                <h3 class="text-xl font-semibold text-vin-rouge">Filtrer</h3>
                <button>
                    <span class="text-vin-rouge" @click="reinitialiserFiltre"
                        >Réinitialiser</span
                    >
                </button>
            </header>
            <!-- Barre de séparation  -->
            <div class="border-t border-gray-300"></div>
            <div class="px-4 py-4">
                <!-- Source -->
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <h4 class="text-vin-rouge text-md font-semibold">
                            Sources
                        </h4>

                        <button
                            @click="showSource = !showSource"
                            class="text-vin-rouge flex items-center justify-center"
                        >
                            <i
                                class="ml-2 material-icons text-3xl text-vin-rou rouge"
                            >
                                {{ showSource ? "expand_less" : "expand_more" }}
                            </i>
                        </button>
                    </div>
                    <div v-show="showSource" class="flex gap-2 my-4">
                        <div
                            v-for="(source, index) in sources"
                            :key="source.id"
                            @click="toggleSource(source)"
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
                                selectedSources.some(
                                    (sourceItem) => sourceItem.id === source.id
                                )
                                    ? 'bg-vin-rouge hover:bg-vin-rouge text-white'
                                    : 'bg-gray-200 hover:bg-gray-300 text-vin-rouge',
                            ]"
                        >
                            <span>{{ source.nom }}</span>
                            <span
                                class="material-icons text-xl"
                                :class="
                                    selectedSources.some(
                                        (sourceItem) =>
                                            sourceItem.id === source.id
                                    )
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
                            v-for="(categorie, index) in categories"
                            :key="categorie.id"
                            @click="toggleCategorie(categorie)"
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

                                selectedCategories.some(
                                    (categorieItem) =>
                                        categorieItem.id === categorie.id
                                )
                                    ? 'bg-vin-rouge hover:bg-vin-rouge text-white'
                                    : 'bg-gray-200 hover:bg-gray-300 text-vin-rouge',
                            ]"
                        >
                            <span>{{ categorie.nom }}</span>
                            <span
                                class="material-icons text-xl"
                                :class="
                                    selectedCategories.some(
                                        (categorieItem) =>
                                            categorieItem.id === categorie.id
                                    )
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
                <!-- Pays -->
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <h4 class="text-vin-rouge text-md font-semibold">
                            Pays
                        </h4>
                        <button
                            @click="showPays = !showPays"
                            class="text-vin-rouge flex items-center justify-center"
                        >
                            <i
                                class="ml-2 material-icons text-3xl text-vin-rou rouge"
                            >
                                {{ !showPays ? "expand_less" : "expand_more" }}
                            </i>
                        </button>
                    </div>
                    <div v-show="!showPays" class="flex flex-wrap gap-4 my-4">
                        <div
                            v-for="(oPays, index) in pays"
                            :key="oPays.id"
                            @click="togglePays(oPays)"
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

                                selectedPays.some(
                                    (PaysItem) => PaysItem.id === oPays.id
                                )
                                    ? 'bg-vin-rouge hover:bg-vin-rouge text-white'
                                    : 'bg-gray-200 hover:bg-gray-300 text-vin-rouge',
                            ]"
                        >
                            <span>{{ oPays.nom }}</span>
                            <span
                                class="material-icons text-xl"
                                :class="
                                    selectedPays.some(
                                        (PaysItem) => PaysItem.id === oPays.id
                                    )
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
                                :min="calcPrixMin"
                                :max="calcPrixMax"
                                step="5"
                                v-model="prixMin"
                            />
                        </div>
                        <div class="flex">
                            <label class="mr-4" for="prixMax">Max </label>
                            <input
                                type="range"
                                :min="prixMin"
                                :max="calcPrixMax"
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
                        :disabled="filteredBouteilles.length === 0"
                        @click="handleValiderFiltre"
                        class="w-full text-white py-2 px-4 rounded-full"
                        :class="
                            filteredBouteilles.length === 0
                                ? 'bg-gray-500'
                                : 'bg-vin-rouge  hover:bg-vin-rouge'
                        "
                    >
                        Voir ({{ filteredBouteilles.length }}) résultats
                    </button>
                </div>
            </div>
        </div>
    </aside>
    <!-- </transition> -->
</template>

<script>
import CategorieDataService from "@/services/CategorieDataService.js";
import { mapGetters, mapMutations } from "vuex";

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
            filteredBouteilles: [],
            categories: [],
            selectedCategories: [],
            pays: [],
            selectedPays: [],
            sources: [
                { id: 1, nom: "SAQ" },
                { id: 2, nom: "Personnalisée" },
            ],
            selectedSources: [],
            showCategorieFiltre: false,
            prixMin: 0,
            prixMax: Infinity,
            nbrEtoileFiltrer: 0,
            showSource: true,
            showCategories: true,
            showPays: false,
            showPrix: true,
            showEtoiles: true,
        };
    },
    computed: {
        adjustedPrixMax: {
            get() {
                return this.prixMax;
            },
            set(newValue) {
                if (newValue < this.prixMin) {
                    this.prixMax = this.prixMin;
                } else {
                    this.prixMax = newValue;
                }
            },
        },
        // ajuster la largeur des inputs de prix
        inputPrixMinWidth() {
            return `${this.prixMin.toString().length * 12}px`;
        },
        inputPrixMaxWidth() {
            return `${this.prixMax.toString().length * 12}px`;
        },
        // Retourne le prix minimum et maximum des bouteilles
        calcPrixMin() {
            return Math.min(
                ...this.bouteilles.map((bouteille) => bouteille.prix)
            );
        },
        calcPrixMax() {
            return Math.max(
                ...this.bouteilles.map((bouteille) => bouteille.prix)
            );
        },
        filteredItems() {
            return this.bouteilles.filter((bouteille) => {
                const estCategorieSelectionnee =
                    this.selectedCategories.length === 0 ||
                    this.selectedCategories.some(
                        (categorieItem) =>
                            categorieItem.id === bouteille.categorie.id
                    );

                const estPaysSelectionne =
                    this.selectedPays.length === 0 ||
                    this.selectedPays.some(
                        (paysItem) => paysItem.id === bouteille.pays.id
                    );

                const estSourceSelectionnee =
                    this.selectedSources.length === 0 ||
                    this.selectedSources.some((sourceItem) =>
                        sourceItem.id === 1
                            ? bouteille.code_saq !== null
                            : sourceItem.id === 2 && bouteille.code_saq === null
                    );

                const estPrixInclus =
                    parseInt(bouteille.prix) >= this.prixMin &&
                    parseInt(bouteille.prix) <= this.prixMax;

                return (
                    estCategorieSelectionnee &&
                    estPaysSelectionne &&
                    estSourceSelectionnee &&
                    estPrixInclus &&
                    Math.floor((bouteille.note * 5) / 100) >=
                        this.nbrEtoileFiltrer
                );
            });
        },
    },
    watch: {
        selectedCategories: {
            handler: function (newVal, oldVal) {
                this.updateFiltredBouteille();
            },
            deep: true,
        },
        selectedPays: {
            handler: function (newVal, oldVal) {
                this.updateFiltredBouteille();
            },
            deep: true,
        },
        selectedSources: {
            handler: function (newVal, oldVal) {
                this.updateFiltredBouteille();
            },
            deep: true,
        },
        prixMin: {
            handler: function (newVal, oldVal) {
                this.updateFiltredBouteille();
            },
        },
        prixMax: {
            handler: function (newVal, oldVal) {
                this.updateFiltredBouteille();
            },
        },
        nbrEtoileFiltrer: {
            handler: function (newVal, oldVal) {
                this.updateFiltredBouteille();
            },
        },
    },
    methods: {
        handleValiderFiltre() {
            this.setCellierFiltreValeurs({
                storeSelectedCategories: this.selectedCategories,
                storeSelectedPays: this.selectedPays,
                storeSelectedSources: this.selectedSources,
                storeSelectedPrixMin: this.prixMin,
                storeSelectedPrixMax: this.prixMax,
                storeSelectedNbrEtoileFiltrer: this.nbrEtoileFiltrer,
            });
            this.filtrer();
            this.$emit("fermer-filtre");
        },
        filtrer() {
            this.$emit("filtrer-bouteilles", this.filteredBouteilles);
        },
        updateFiltredBouteille() {
            this.filteredBouteilles = this.filteredItems;
        },
        // Fetch les catégories
        fetchCategories: async function () {
            try {
                const reponse = await CategorieDataService.getAll();
                this.categories = reponse.data.categories;
            } catch (error) {
                console.error(error);
            } finally {
            }
        },
        // Extraire les pays de la liste de bouteilles
        extrairePays: function (bouteilles) {
            // On utilise reduce pour créer un tableau de pays unique
            return bouteilles.reduce((accumulateur, bouteille) => {
                // On vérifie si le pays existe déjà dans le tableau
                const estExist = accumulateur.find(
                    (item) => item.id === bouteille.pays.id
                );
                // Si le pays n'existe pas, on l'ajoute au tableau
                if (!estExist) {
                    accumulateur.push({
                        nom: bouteille.pays.nom,
                        id: bouteille.pays.id,
                    });
                }
                // On retourne le tableau
                return accumulateur;
            }, []); // On initialise le tableau avec un tableau vide
        },

        toggleCategorie(oCategorie) {
            console.log(
                this.$store.state.cellierFiltreValeurs.storeSelectedCategories
            );
            const selectedIndex = this.selectedCategories.findIndex(
                (categorie) => categorie.id === oCategorie.id
            );
            if (selectedIndex >= 0) {
                this.selectedCategories.splice(selectedIndex, 1);
            } else {
                this.selectedCategories.push(oCategorie);
            }
            console.log(
                this.$store.state.cellierFiltreValeurs.storeSelectedCategories
            );
        },
        toggleSource(oSource) {
            const selectedIndex = this.selectedSources.findIndex(
                (source) => source.id === oSource.id
            );

            if (selectedIndex >= 0) {
                this.selectedSources.splice(selectedIndex, 1);
            } else {
                this.selectedSources.push(oSource);
            }
        },

        togglePays(oPays) {
            const selectedIndex = this.selectedPays.findIndex(
                (pays) => pays.id === oPays.id
            );

            if (selectedIndex >= 0) {
                this.selectedPays.splice(selectedIndex, 1);
            } else {
                this.selectedPays.push(oPays);
            }
        },

        fermerFiltre() {
            console.log(this.$store.state.cellierFiltreValeurs);
            this.$emit("fermer-filtre");
        },
        reinitialiserFiltre() {
            this.filteredBouteilles = this.bouteilles;
            this.selectedCategories = [];
            this.selectedPays = [];
            this.selectedSources = [];
            this.prixMin = this.calcPrixMin;
            this.prixMax = this.calcPrixMax;
            this.nbrEtoileFiltrer = 0;
        },
        ...mapMutations(["setCellierFiltreValeurs"]),
    },
    mounted() {
        this.fetchCategories();
        this.pays = this.extrairePays(this.bouteilles);
        this.selectedCategories = this.$store.getters.cellierFiltreValeurs
            .storeSelectedCategories
            ? JSON.parse(
                  JSON.stringify(
                      this.$store.getters.cellierFiltreValeurs
                          .storeSelectedCategories
                  )
              )
            : [];
        this.selectedPays = this.$store.getters.cellierFiltreValeurs
            .storeSelectedPays
            ? JSON.parse(
                  JSON.stringify(
                      this.$store.getters.cellierFiltreValeurs.storeSelectedPays
                  )
              )
            : [];
        this.selectedSources = this.$store.getters.cellierFiltreValeurs
            .storeSelectedSources
            ? JSON.parse(
                  JSON.stringify(
                      this.$store.getters.cellierFiltreValeurs
                          .storeSelectedSources
                  )
              )
            : [];
        this.prixMin = this.$store.getters.cellierFiltreValeurs
            .storeSelectedPrixMin
            ? JSON.parse(
                  JSON.stringify(
                      this.$store.getters.cellierFiltreValeurs
                          .storeSelectedPrixMin
                  )
              )
            : this.calcPrixMin;
        this.prixMax = this.$store.getters.cellierFiltreValeurs
            .storeSelectedPrixMax
            ? JSON.parse(
                  JSON.stringify(
                      this.$store.getters.cellierFiltreValeurs
                          .storeSelectedPrixMax
                  )
              )
            : this.calcPrixMax;

        this.nbrEtoileFiltrer = this.$store.getters.cellierFiltreValeurs
            .storeSelectedNbrEtoileFiltrer
            ? JSON.parse(
                  JSON.stringify(
                      this.$store.getters.cellierFiltreValeurs
                          .storeSelectedNbrEtoileFiltrer
                  )
              )
            : 0;
    },
};
</script>

<style></style>
