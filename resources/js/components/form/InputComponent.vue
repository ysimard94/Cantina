<template>
    <div class="input-component">
        <label
            v-if="label"
            :for="name"
            class="block text-sm font-medium text-gray-700"
        >
            {{ label }}
        </label>
        <input
            :type="type"
            :id="name"
            :name="name"
            v-model="inputValue"
            class="mt-1 block w-full rounded-md border-red-400 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            :placeholder="placeholder"
        />
    </div>
</template>

<script>
import { mapMutations } from "vuex";
export default {
    name: "InputComponent",
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
    },
    data() {
        return {
            inputValue: "",
        };
    },
    watch: {
        inputValue(value) {
            this.$emit("input-change", { key: this.name, value: value });
        },
    },
};
</script>
