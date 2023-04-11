<template>
    <div>
        <label :for="name" class="form-label">{{ label }}</label>
        <select
            :name="name"
            :id="name"
            class="form-control"
            :required="required"
            v-model="selectedValue"
        >
            <option value="" disabled selected>{{ placeholder }}</option>
            <option
                v-for="(option, index) in field.options"
                :key="index"
                :value="option.value"
            >
                {{ option.label }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    name: "SelectComponent",
    props: {
        label: String,
        name: String,
        placeholder: String,
        required: Boolean,
        field: Object,
    },
    data() {
        return {
            selectedValue: "",
        };
    },
    watch: {
        selectedValue(value) {
            this.$emit("input-change", { key: this.name, value: value });
        },
    },
};
</script>
