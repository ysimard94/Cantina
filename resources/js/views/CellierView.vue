<template>
    <div class="container">
        <div class="row">
            <bouteille-card/>
            <bouteille-card/>
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
