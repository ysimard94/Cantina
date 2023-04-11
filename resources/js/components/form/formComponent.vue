<template>
    <form>
        <h1>{{ title }}</h1>
        <slot
            @input-change="handleInputChange"
            @increment-index="incrementFormIndex"
            @decrement-index="decrementFormIndex"
        />
    </form>
</template>

<script>
import { mapMutations } from "vuex";
import fieldComponent from "@/components/form/fieldComponent.vue";
export default {
    name: "formComponent",
    props: {
        title: String,
        formName: String,
    },
    mounted() {
        this.addFormKey(this.formName);
    },
    methods: {
        ...mapMutations([
            "addFormKey",
            "setFormValue",
            "incrementFormIndex",
            "decrementFormIndex",
        ]),
        handleInputChange({ key, value }) {
            // console.log(this.formName);
            this.setFormValue({ formName: this.formName, key, value });
        },
        incrementIndex() {
            this.incrementFormIndex(this.formName);
        },
        decrementIndex() {
            this.decrementFormIndex(this.formName);
        },
    },
};
</script>
