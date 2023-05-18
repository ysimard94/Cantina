<template>
    <div v-if="afficherTemplate" class="mx-2 mt-8">
        <h1 class="text-5xl mb-4 text-vin-rouge">Historique</h1>
        <template v-if="archives.length === 0">
            <p>Il n'y a aucune bouteille archivée</p>
        </template>
        <!-- Sinon itérer à travers pour montrer les bouteilles dans la liste -->
        <template v-else>
            <!-- recherche dans les archives -->
            <div class="flex items-center mx-auto p-2 mb-2 text-lg">
                <form @submit.prevent="" class="w-full">
                    <label class="relative flex items-center">
                        <input
                            v-model="recherche"
                            type="text"
                            class="w-full py-1 pl-2 pr-[32px] rounded"
                            placeholder="Rechercher dans les archives"
                            @input="rechercheBouteillesCellier"
                        />
                        <button
                            class="material-symbols-outlined absolute right-0 p-1"
                            @click="
                                recherche === ''
                                    ? rechercheBouteillesCellier()
                                    : effacerRecherche()
                            "
                        >
                            {{ recherche === "" ? "search" : "clear" }}
                        </button>
                    </label>
                </form>
            </div>
            <!-- Section pour filtre et tri -->
            <div class="md:col-span-2 flex justify-between items-center mb-4">
                <button
                    class="mr-auto rounded pt-1 pb-1 pl-1 pr-10 material-symbols-outlined text-4xl font-medium text-vin-rouge"
                    @click="estOuvertFiltre = !estOuvertFiltre"
                >
                    tune
                </button>
                <transition
                    enter-active-class="transition duration-500 ease-in-out transform"
                    enter-from-class="-translate-x-full"
                    enter-to-class="translate-x-0"
                    leave-active-class="transition duration-500 ease-in-out transform"
                    leave-from-class="translate-x-0"
                    leave-to-class="-translate-x-full"
                >
                    <FiltreComponent
                        v-if="estOuvertFiltre"
                        @filtrer-bouteilles="filtrerBouteilles"
                        @fermer-filtre="fermerFiltre"
                        :bouteilles="getBouteilles"
                        parent="archive"
                        class="w-full fixed inset-0 mb-15 z-50"
                    />
                </transition>
                <button
                    class="rounded material-symbols-outlined text-4xl font-medium text-vin-rouge pr-1"
                    :class="{
                        'rotate-[360deg] ease-in-out duration-500': estRotation,
                    }"
                    @click="
                        reinitialisationBouteilles();
                        rotation();
                    "
                >
                    refresh
                </button>

                <button
                    class="rounded material-symbols-outlined text-4xl font-medium text-vin-rouge pr-1 ease-in-out duration-500"
                    :class="{ '-scale-y-100': triParNom }"
                    @click="fTriParNom"
                >
                    swap_vert
                </button>
                <button
                    class="rounded material-symbols-outlined text-4xl font-medium text-vin-rouge pr-1 ease-in-out duration-500"
                    :class="{ '-scale-y-100': triParDate }"
                    @click="fTriParDate"
                >
                    date_range
                </button>
            </div>
            <p
                v-if="recherche !== '' && bouteillesRecherche.length === 0"
                class="text-xl mt-4 border-2 border-vin-rouge rounded p-4 mx-2"
            >
                Aucun résultat trouvé pour votre recherche. Essayez un autre
                terme de recherche ou ajoutez plus de bouteilles à votre
                cellier.
            </p>
            <ul class="flex flex-col gap-2">
                <li
                    v-for="(archive, index) in archivesAffiches"
                    :key="archive.id"
                >
                    <BouteilleComponentArchive
                        :index="index"
                        :archive="archive"
                        @ajouter-bouteille-a-la-liste="ajouterBouteilleALaListe"
                    />
                </li>
            </ul>
        </template>
    </div>
</template>

<script>
import BouteilleDataService from "@/services/BouteilleDataService";
import BouteilleComponentArchive from "@/components/BouteilleComponentArchive.vue";
import FiltreComponent from "@/components/FiltreComponent.vue";
import { mapMutations } from "vuex";

export default {
    name: "ArchiveView",
    components: {
        BouteilleComponentArchive,
        FiltreComponent,
    },
    data() {
        return {
            afficherTemplate: false,
            archives: [],
            bouteilles: [],
            userId: null,
            filteredBouteilles: [],
            estOuvertFiltre: false,
            estRotation: false,
            est180: false,
            triParNom: false,
            triParDate: false,
            bouteillesRecherche: [],
            recherche: "",
        };
    },
    computed: {
        getBouteilles() {
            return this.archives.map((archive) => archive.bouteille);
        },
        archivesAffiches() {
            //
            if (this.recherche !== "") {
                return this.archives.filter((archive) => {
                    return this.bouteillesRecherche.some((bouteille) => {
                        if (archive.bouteille_id === bouteille.bouteille_id) {
                            console.log("found");
                        }
                        return archive.bouteille_id === bouteille.bouteille_id;
                    });
                });
            } else if (this.filteredBouteilles.length > 0) {
                return this.archives.filter((archive) => {
                    return this.filteredBouteilles.some((bouteille) => {
                        return archive.bouteille_id === bouteille.id;
                    });
                });
            } else {
                return this.archives;
            }
        },
    },

    methods: {
        // Appliquer le filtre pour afficher toutes les bouteilles filtrées
        filtrerBouteilles(filteredBouteilles) {
            this.filteredBouteilles = filteredBouteilles;
        },

        // Montrer le filtre
        montrerFiltre() {
            this.estOuvertFiltre = true;
        },

        // fermer le filtre
        fermerFiltre() {
            this.estOuvertFiltre = false;
        },
        //Animation du bouton de réinitialisation
        rotation() {
            this.estRotation = true;
            setTimeout(() => {
                this.estRotation = false;
            }, 500);
        },

        //Animation du bouton de tri
        rotationTri() {
            this.est180 = !this.est180;
        },
        // Fonction de tri
        triCellier() {},
        async reinitialisationBouteilles() {
            this.filteredBouteilles = [];
            // Mettre à jour les valeurs du filtre
            this.setArchiveFiltreValeurs({});

            await this.chargerArchives();
        },
        // Obtenir la liste des archives de l'utilisateur
        async chargerArchives() {
            try {
                const response =
                    await BouteilleDataService.obtenirArchivesUtilisateur(
                        this.$store.getters.session.utilisateur_id
                    );

                this.archives = response.data.archives;
            } catch (error) {
            } finally {
                this.$nextTick(() => {
                    this.$emit("loading:end");
                    this.afficherTemplate = true;
                });
            }
        },
        // Va ajouter la bouteille à la liste d'achats de l'utilisateur
        async ajouterBouteilleALaListe(bouteilleId) {
            try {
                const reponse =
                    await BouteilleDataService.ajouterBouteilleALaListe(
                        this.$store.state.session.utilisateur_id,
                        bouteilleId
                    );

                this.$router.push({ name: "liste-achats" });
            } catch (error) {}
        },
        // Pour fermer le popup au clic du bouton X
        fermerPopup() {
            this.message = "";
            this.estSuccessPopup = false;
        },
        // Fonction de tri par nom
        fTriParNom() {
            this.triParNom = !this.triParNom;
            this.triParDate = false;

            this.archivesAffiches.sort((a, b) => {
                const NomA = a.bouteille.nom.toUpperCase();
                const NomB = b.bouteille.nom.toUpperCase();

                if (NomA < NomB) {
                    return this.triParNom ? -1 : 1;
                }
                if (NomA > NomB) {
                    return this.triParNom ? 1 : -1;
                }

                return 0;
            });
        },

        // Fonction de tri par date
        fTriParDate() {
            this.triParDate = !this.triParDate;
            this.triParNom = false;

            this.archivesAffiches.sort((a, b) => {
                const dateA = new Date(a.created_at);
                const dateB = new Date(b.created_at);

                return this.triParDate ? dateA - dateB : dateB - dateA;
            });
        },
        //Applique le résultat de la recherche avec les filtres ou non dans le celliers
        rechercheBouteillesCellier() {
            this.bouteillesRecherche = this.archives.filter((archive) => {
                return archive.bouteille.nom
                    .toLowerCase()
                    .includes(this.recherche.toLowerCase());
            });
            if (this.recherche === "") {
                this.effacerRecherche();
            }
            // console.log(this.bouteillesRecherche);
        },
        effacerRecherche() {
            this.recherche = "";
            this.bouteillesRecherche = [];
        },
        ...mapMutations(["setArchiveFiltreValeurs"]),
    },
    async mounted() {
        this.$emit("loading:start");
        //  Charger les archive de l'utilisateur
        await this.chargerArchives();
        this.reinitialisationBouteilles();
    },
};
</script>
