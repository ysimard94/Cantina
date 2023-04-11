<template>
    <component
        :is="currentComponent"
        @input-change="handleInputChange"
        @increment-index="incrementIndex"
        @decrement-index="decrementIndex"
        :label="label"
        :name="name"
        :placeholder="placeholder"
        :type="type"
        :field="field"
    />
</template>

<script>
import InputComponent from "@/components/form/InputComponent.vue";
import TextareaComponent from "@/components/form/TextareaComponent.vue";
import SelectComponent from "@/components/form/SelectComponent.vue";
import { markRaw } from "vue";

export default {
    name: "fieldComponent",
    components: {
        InputComponent,
        TextareaComponent,
        SelectComponent,
    },
    props: {
        label: {
            type: String,
            default: "",
        },
        name: {
            type: String,
            default: "inputField",
        },
        placeholder: {
            type: String,
            default: "",
        },
        type: {
            type: String,
            default: "text",
        },
        field: {
            type: Object,
            default: { name: "", options: [] },
        },
    },
    data() {
        return {
            currentComponent: null,
        };
    },
    methods: {
        handleInputChange(payload) {
            this.$parent.handleInputChange(payload);
        },
    },
    mounted() {
        switch (this.field.name) {
            case "input":
                this.currentComponent = markRaw(InputComponent);
                break;
            case "textarea":
                this.currentComponent = markRaw(TextareaComponent);
                break;
            case "select":
                this.currentComponent = markRaw(SelectComponent);
                break;
            default:
                break;
        }
        this.$parent.incrementIndex();
    },
    destroyed() {
        this.$parent.decrementIndex();
    },
};
</script>
