<template>
    <div>
        <h1>Archives</h1>
        <ul class="flex flex-col gap-2">
            <li v-for="(archive, index) in archives" :key="archive.id">
                <BouteilleComponentArchive :index="index" :archive="archive" />
            </li>
        </ul>
    </div>
</template>

<script>
import BouteilleDataService from "@/services/BouteilleDataService";
import BouteilleComponentArchive from "@/components/BouteilleComponentArchive.vue";

export default {
    name: "ArchiveView",
    components: {
        BouteilleComponentArchive,
    },
    data() {
        return {
            archives: [],
            userId: null,
        };
    },
    methods: {
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
    },
    async mounted() {
        //  Charger les archive de l'utilisateur
        await this.chargerArchives();
    },
};
</script>
