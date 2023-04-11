<template>
    <div class="textarea-component">
        <label
            v-if="label"
            :for="name"
            class="block text-sm font-medium text-gray-700"
        >
            {{ label }}
        </label>
        <textarea
            :id="name"
            :name="name"
            v-model="textareaValue"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            :placeholder="placeholder"
            :required="required"
        ></textarea>
    </div>
</template>

<script>
import { mapMutations } from "vuex";
export default {
    name: "TextareaComponent",
    props: {
        label: String,
        name: String,
        placeholder: String,
        required: Boolean,
    },
    data() {
        return {
            textareaValue: "",
        };
    },
    watch: {
        textareaValue(value) {
            this.$emit("input-change", { key: this.name, value: value });
        },
    },
};
</script>
