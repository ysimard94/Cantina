<template>
    <div class="mx-2">
        <h3 class="mb-4 text-vin-rouge font-bold text-xl mt-6">
            Historique des bouteilles bues
        </h3>
        <!-- Section pour filtre et tri -->
        <div class="md:col-span-2 flex justify-between items-center">
            <button
                class="mr-auto rounded pt-1 pb-1 pl-1 pr-10"
                @click="estOuvertFiltre = !estOuvertFiltre"
            >
                <span
                    class="material-symbols-outlined text-4xl font-medium text-vin-rouge"
                    >tune</span
                >
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
                class="rounded"
                @click="
                    reinitialisationBouteilles();
                    rotation();
                "
            >
                <span
                    class="material-symbols-outlined text-4xl font-medium text-vin-rouge pr-1"
                    :class="{
                        'rotate-[360deg] ease-in-out duration-500': estRotation,
                    }"
                >
                    refresh
                </span>
            </button>

            <button class="rounded" @click="fTriParNom">
                <span
                    class="material-symbols-outlined text-4xl font-medium text-vin-rouge pr-1 ease-in-out duration-500"
                    :class="{ '-scale-y-100': triParNom }"
                >
                    swap_vert
                </span>
            </button>
            <button class="rounded" @click="fTriParDate">
                <span
                    class="material-symbols-outlined text-4xl font-medium text-vin-rouge pr-1 ease-in-out duration-500"
                    :class="{ '-scale-y-100': triParDate }"
                >
                    date_range
                </span>
            </button>
        </div>
        <ul class="flex flex-col gap-2">
            <li v-for="(archive, index) in archivesAffiches" :key="archive.id">
                <BouteilleComponentArchive :index="index" :archive="archive" />
            </li>
        </ul>
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
            archives: [],
            bouteilles: [],
            userId: null,
            filteredBouteilles: [],
            estOuvertFiltre: false,
            estRotation: false,
            est180: false,
            triParNom: false,
            triParDate: false,
        };
    },
    computed: {
        getBouteilles() {
            return this.archives.map((archive) => archive.bouteille);
        },
        archivesAffiches() {
            return this.filteredBouteilles.length > 0
                ? this.archives.filter((archive) => {
                      return this.filteredBouteilles.some((bouteille) => {
                          return archive["bouteille_id"] === bouteille.id;
                      });
                  })
                : this.archives;
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
        reinitialisationBouteilles() {
            this.filteredBouteilles = [];
            // Mettre à jour les valeurs du filtre
            this.setArchiveFiltreValeurs({});
        },
        async chargerArchives() {
            try {
                const response =
                    await BouteilleDataService.obtenirArchivesUtilisateur(
                        this.$store.getters.session.utilisateur_id
                    );
                this.archives = response.data.archives;
            } catch (error) {
                console.log(error);
            }
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
        ...mapMutations(["setArchiveFiltreValeurs"]),
    },
    async mounted() {
        //  Charger les archive de l'utilisateur
        await this.chargerArchives();
        this.reinitialisationBouteilles();
    },
};
</script>
