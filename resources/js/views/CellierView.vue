<template>
    <div class="container">
        <h1>mon cellier</h1>
        <div class="row">
            <bouteille-card/>
        </div>
    </div>
</template>

<script>
import BouteilleComponent from "@/components/BouteilleComponent.vue";

export default {

    components: {
      'bouteille-card': BouteilleComponent

    },
    methods: {

    },
}
</script>
