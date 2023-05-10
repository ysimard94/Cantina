<template>
    <div>
        <h1>Archives</h1>
        <ul>
            <li v-for="archive in archives" :key="archive.id">
                <strong>Date:</strong> {{ archive.created_at }}<br />
                <strong>Bouteille:</strong> {{ archive.bouteille.nom }}<br />
                <strong>User:</strong> {{ archive.utilisateur.nom }}
            </li>
        </ul>
    </div>
</template>

<script>
import BouteilleDataService from "@/services/BouteilleDataService";

export default {
    name: "ArchiveView",
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
